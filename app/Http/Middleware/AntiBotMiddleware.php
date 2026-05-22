<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class AntiBotMiddleware
{
    // Honeypot field name (invisible to humans, bots will fill it)
    const HONEYPOT_FIELD = '_email_confirm';
    const HONEYPOT_TIME_FIELD = '_form_start';
    const MIN_SUBMIT_SECONDS = 3;

    // Known bot/scraper user-agent patterns
    protected array $badUserAgents = [
        'curl', 'wget', 'python-requests', 'python-urllib', 'go-http-client',
        'java/', 'libwww-perl', 'scrapy', 'nikto', 'sqlmap', 'masscan',
        'zgrab', 'dirbuster', 'nmap', 'metasploit', 'zgrab2',
        'ahrefsbot', 'semrushbot', 'dotbot', 'blexbot',
        'mj12bot', 'petalbot',
    ];

    // Gambling / spam injection keywords (Indonesian + English)
    protected array $gamblingKeywords = [
        'slot online', 'judi online', 'togel', 'situs judi', 'agen slot',
        'bandar slot', 'casino online', 'poker online', 'pragmatic play',
        'pg soft', 'joker123', 'habanero', 'spadegaming', 'cq9',
        'deposit pulsa', 'rtp slot', 'gacor', 'maxwin', 'jackpot',
        'prediksi togel', 'syair togel', 'angka jitu', 'bocoran slot',
        'link alternatif', 'daftar sekarang bonus', 'bonus new member',
        'scatter', 'wild symbol', 'free spin gratis',
    ];

    // Suspicious injection patterns
    protected array $injectionPatterns = [
        '/<script[\s>]/i',
        '/javascript:/i',
        '/vbscript:/i',
        '/on\w+\s*=/i',      // onload=, onclick=, etc.
        '/data:text\/html/i',
        '/\beval\s*\(/i',
        '/\bexec\s*\(/i',
        '/\bsystem\s*\(/i',
        '/\bunion\s+select/i',
        '/\bdrop\s+table/i',
        '/\binsert\s+into/i',
        '/--\s*$/',           // SQL comment
        '/;\s*--/i',
        '/\bxp_cmdshell/i',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        // Only check POST/PUT/PATCH requests
        if (!$request->isMethod('GET') && !$request->isMethod('HEAD')) {

            // 1. Honeypot check: bot filled the invisible field
            if ($request->filled(self::HONEYPOT_FIELD)) {
                Log::warning('Bot detected via honeypot', [
                    'ip' => $request->ip(),
                    'ua' => $request->userAgent(),
                    'url' => $request->url(),
                ]);
                return $this->blockRequest($request);
            }

            // 2. Time check: form submitted too fast (bot behavior)
            $startTime = $request->input(self::HONEYPOT_TIME_FIELD);
            if ($startTime && (time() - (int)$startTime) < self::MIN_SUBMIT_SECONDS) {
                Log::warning('Bot detected: form submitted too fast', [
                    'ip' => $request->ip(),
                    'elapsed' => time() - (int)$startTime,
                ]);
                return $this->blockRequest($request);
            }

            // 3. Gambling/spam content injection check
            $textInputs = $this->getTextInputs($request);
            if ($this->containsGamblingContent($textInputs)) {
                Log::warning('Gambling content injection attempt blocked', [
                    'ip' => $request->ip(),
                    'url' => $request->url(),
                ]);
                abort(422, 'Konten yang Anda kirim mengandung kata-kata yang tidak diizinkan.');
            }

            // 4. SQL/script injection pattern check
            if ($this->containsInjection($textInputs)) {
                Log::warning('Injection attempt blocked', [
                    'ip' => $request->ip(),
                    'url' => $request->url(),
                ]);
                abort(422, 'Permintaan tidak valid terdeteksi.');
            }
        }

        // 5. Bad user agent check (for all requests)
        $userAgent = strtolower($request->userAgent() ?? '');
        foreach ($this->badUserAgents as $bad) {
            if (str_contains($userAgent, $bad)) {
                Log::info('Bad bot user-agent blocked', ['ua' => $userAgent, 'ip' => $request->ip()]);
                abort(403, 'Access denied.');
            }
        }

        return $next($request);
    }

    protected function getTextInputs(Request $request): array
    {
        $skip = ['_token', '_method', self::HONEYPOT_FIELD, self::HONEYPOT_TIME_FIELD, 'password', 'password_confirmation'];
        $inputs = [];

        foreach ($request->all() as $key => $value) {
            if (in_array($key, $skip)) continue;
            if (is_string($value)) {
                $inputs[] = $value;
            } elseif (is_array($value)) {
                foreach ($value as $v) {
                    if (is_string($v)) $inputs[] = $v;
                }
            }
        }

        return $inputs;
    }

    protected function containsGamblingContent(array $inputs): bool
    {
        $combined = strtolower(implode(' ', $inputs));
        foreach ($this->gamblingKeywords as $keyword) {
            if (str_contains($combined, $keyword)) {
                return true;
            }
        }
        return false;
    }

    protected function containsInjection(array $inputs): bool
    {
        $combined = implode(' ', $inputs);
        foreach ($this->injectionPatterns as $pattern) {
            if (preg_match($pattern, $combined)) {
                return true;
            }
        }
        return false;
    }

    protected function blockRequest(Request $request): Response
    {
        if ($request->expectsJson()) {
            return response()->json(['message' => 'Request ditolak.'], 403);
        }
        abort(403, 'Akses ditolak. Aktivitas mencurigakan terdeteksi.');
    }
}
