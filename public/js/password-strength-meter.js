// Password Strength Meter Component
// Usage: <div class="password-strength-meter" data-password-input="#password"></div>

document.addEventListener('DOMContentLoaded', function() {
    const meters = document.querySelectorAll('.password-strength-meter');
    
    meters.forEach(meter => {
        const inputSelector = meter.getAttribute('data-password-input');
        const passwordInput = document.querySelector(inputSelector);
        
        if (!passwordInput) return;
        
        // Create meter HTML
        meter.innerHTML = `
            <div class="mt-2">
                <div class="flex gap-1 mb-2">
                    <div class="strength-bar flex-1 h-2 rounded bg-gray-200"></div>
                    <div class="strength-bar flex-1 h-2 rounded bg-gray-200"></div>
                    <div class="strength-bar flex-1 h-2 rounded bg-gray-200"></div>
                    <div class="strength-bar flex-1 h-2 rounded bg-gray-200"></div>
                </div>
                <div class="strength-text text-sm font-medium"></div>
                <ul class="strength-requirements text-xs text-gray-600 mt-2 space-y-1">
                    <li class="req-length flex items-center">
                        <span class="icon mr-2">○</span>
                        <span>Minimal 8 karakter</span>
                    </li>
                    <li class="req-uppercase flex items-center">
                        <span class="icon mr-2">○</span>
                        <span>Huruf besar (A-Z)</span>
                    </li>
                    <li class="req-lowercase flex items-center">
                        <span class="icon mr-2">○</span>
                        <span>Huruf kecil (a-z)</span>
                    </li>
                    <li class="req-number flex items-center">
                        <span class="icon mr-2">○</span>
                        <span>Angka (0-9)</span>
                    </li>
                    <li class="req-special flex items-center">
                        <span class="icon mr-2">○</span>
                        <span>Karakter khusus (!@#$%^&*)</span>
                    </li>
                </ul>
            </div>
        `;
        
        const bars = meter.querySelectorAll('.strength-bar');
        const strengthText = meter.querySelector('.strength-text');
        
        passwordInput.addEventListener('input', function() {
            const password = this.value;
            const strength = calculateStrength(password);
            
            // Reset bars
            bars.forEach(bar => {
                bar.classList.remove('bg-red-500', 'bg-orange-500', 'bg-yellow-500', 'bg-green-500');
                bar.classList.add('bg-gray-200');
            });
            
            // Update bars based on strength
            let color = 'bg-gray-200';
            let text = '';
            let textColor = 'text-gray-600';
            
            if (strength.score === 0) {
                text = '';
            } else if (strength.score === 1) {
                color = 'bg-red-500';
                text = 'Sangat Lemah';
                textColor = 'text-red-500';
                bars[0].classList.remove('bg-gray-200');
                bars[0].classList.add(color);
            } else if (strength.score === 2) {
                color = 'bg-orange-500';
                text = 'Lemah';
                textColor = 'text-orange-500';
                bars[0].classList.remove('bg-gray-200');
                bars[0].classList.add(color);
                bars[1].classList.remove('bg-gray-200');
                bars[1].classList.add(color);
            } else if (strength.score === 3) {
                color = 'bg-yellow-500';
                text = 'Cukup Kuat';
                textColor = 'text-yellow-600';
                for (let i = 0; i < 3; i++) {
                    bars[i].classList.remove('bg-gray-200');
                    bars[i].classList.add(color);
                }
            } else if (strength.score >= 4) {
                color = 'bg-green-500';
                text = 'Kuat';
                textColor = 'text-green-500';
                bars.forEach(bar => {
                    bar.classList.remove('bg-gray-200');
                    bar.classList.add(color);
                });
            }
            
            strengthText.textContent = text;
            strengthText.className = `strength-text text-sm font-medium ${textColor}`;
            
            // Update requirements
            updateRequirement('.req-length', strength.hasMinLength);
            updateRequirement('.req-uppercase', strength.hasUpperCase);
            updateRequirement('.req-lowercase', strength.hasLowerCase);
            updateRequirement('.req-number', strength.hasNumber);
            updateRequirement('.req-special', strength.hasSpecial);
        });
        
        function updateRequirement(selector, isMet) {
            const req = meter.querySelector(selector);
            const icon = req.querySelector('.icon');
            
            if (isMet) {
                icon.textContent = '✓';
                icon.classList.add('text-green-500', 'font-bold');
                req.classList.add('text-green-600');
            } else {
                icon.textContent = '○';
                icon.classList.remove('text-green-500', 'font-bold');
                req.classList.remove('text-green-600');
            }
        }
        
        function calculateStrength(password) {
            const strength = {
                score: 0,
                hasMinLength: password.length >= 8,
                hasUpperCase: /[A-Z]/.test(password),
                hasLowerCase: /[a-z]/.test(password),
                hasNumber: /[0-9]/.test(password),
                hasSpecial: /[!@#$%^&*(),.?":{}|<>]/.test(password)
            };
            
            if (password.length === 0) return strength;
            
            // Calculate score
            if (strength.hasMinLength) strength.score++;
            if (strength.hasUpperCase) strength.score++;
            if (strength.hasLowerCase) strength.score++;
            if (strength.hasNumber) strength.score++;
            if (strength.hasSpecial) strength.score++;
            
            return strength;
        }
    });
});
