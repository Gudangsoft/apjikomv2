<!-- Birthday Greeting Component -->
<!-- Include this in member dashboard -->
<?php
    $user = Auth::user();
    $member = $user->member;
    $today = now();
    $isBirthday = false;
    
    if ($member && $member->date_of_birth) {
        $birthDate = \Carbon\Carbon::parse($member->date_of_birth);
        $isBirthday = $birthDate->format('m-d') === $today->format('m-d');
    }
?>

<?php if($isBirthday): ?>
<div id="birthdayGreeting" class="fixed inset-0 z-50 flex items-center justify-center" style="background: rgba(0, 0, 0, 0.7); backdrop-filter: blur(5px);">
    <div class="birthday-card relative bg-gradient-to-br from-purple-600 via-pink-500 to-orange-400 rounded-3xl shadow-2xl p-8 max-w-lg mx-4 transform animate-bounce-in">
        <!-- Close Button -->
        <button onclick="closeBirthdayGreeting()" class="absolute top-4 right-4 text-white hover:text-gray-200 text-2xl font-bold z-10">
            ×
        </button>
        
        <!-- Confetti Animation -->
        <div class="confetti-container absolute inset-0 overflow-hidden rounded-3xl pointer-events-none">
            <div class="confetti" style="left: 10%; animation-delay: 0s;"></div>
            <div class="confetti" style="left: 20%; animation-delay: 0.2s;"></div>
            <div class="confetti" style="left: 30%; animation-delay: 0.4s;"></div>
            <div class="confetti" style="left: 40%; animation-delay: 0.6s;"></div>
            <div class="confetti" style="left: 50%; animation-delay: 0.8s;"></div>
            <div class="confetti" style="left: 60%; animation-delay: 1s;"></div>
            <div class="confetti" style="left: 70%; animation-delay: 1.2s;"></div>
            <div class="confetti" style="left: 80%; animation-delay: 1.4s;"></div>
            <div class="confetti" style="left: 90%; animation-delay: 1.6s;"></div>
        </div>
        
        <!-- Balloons -->
        <div class="balloons absolute inset-0 pointer-events-none">
            <div class="balloon balloon-1" style="left: 10%;">🎈</div>
            <div class="balloon balloon-2" style="left: 30%;">🎈</div>
            <div class="balloon balloon-3" style="left: 50%;">🎈</div>
            <div class="balloon balloon-4" style="left: 70%;">🎈</div>
            <div class="balloon balloon-5" style="left: 90%;">🎈</div>
        </div>
        
        <!-- Content -->
        <div class="relative z-10 text-center text-white">
            <!-- Cake Icon Animation -->
            <div class="text-8xl mb-4 animate-bounce-slow">
                🎂
            </div>
            
            <!-- Greeting Text -->
            <h2 class="text-4xl font-bold mb-2 animate-fade-in">
                Selamat Ulang Tahun! 🎉
            </h2>
            
            <p class="text-2xl font-semibold mb-4 animate-fade-in-delay">
                <?php echo e($user->name); ?>

            </p>
            
            <div class="bg-white/20 backdrop-blur rounded-xl p-4 mb-6 animate-slide-up">
                <p class="text-lg">
                    Semoga di usia yang baru ini, Anda senantiasa diberikan kesehatan, keberkahan, dan kesuksesan dalam setiap langkah. 
                    Terima kasih telah menjadi bagian dari keluarga besar <strong>APJIKOM</strong>!
                </p>
            </div>
            
            <!-- Age Badge -->
            <?php
                $age = $today->year - $birthDate->year;
            ?>
            <div class="inline-block bg-white text-purple-600 px-6 py-3 rounded-full font-bold text-xl shadow-lg animate-pulse-slow mb-4">
                🎊 <?php echo e($age); ?> Tahun 🎊
            </div>
            
            <!-- Stars -->
            <div class="stars mt-4">
                <span class="star">⭐</span>
                <span class="star">⭐</span>
                <span class="star">⭐</span>
                <span class="star">⭐</span>
                <span class="star">⭐</span>
            </div>
            
            <!-- Gift Icon -->
            <div class="text-6xl mt-4 animate-shake">
                🎁
            </div>
            
            <button onclick="closeBirthdayGreeting()" class="mt-6 bg-white text-purple-600 px-8 py-3 rounded-full font-bold text-lg hover:bg-gray-100 transition transform hover:scale-105 shadow-lg">
                Terima Kasih! 💝
            </button>
        </div>
    </div>
</div>

<style>
    /* Animations */
    @keyframes bounce-in {
        0% {
            transform: scale(0) rotate(-180deg);
            opacity: 0;
        }
        50% {
            transform: scale(1.1) rotate(10deg);
        }
        100% {
            transform: scale(1) rotate(0deg);
            opacity: 1;
        }
    }
    
    @keyframes bounce-slow {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-20px);
        }
    }
    
    @keyframes fade-in {
        0% {
            opacity: 0;
            transform: translateY(-20px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes fade-in-delay {
        0% {
            opacity: 0;
            transform: translateY(-20px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes slide-up {
        0% {
            opacity: 0;
            transform: translateY(30px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes pulse-slow {
        0%, 100% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.05);
        }
    }
    
    @keyframes shake {
        0%, 100% {
            transform: rotate(0deg);
        }
        10%, 30%, 50%, 70%, 90% {
            transform: rotate(-10deg);
        }
        20%, 40%, 60%, 80% {
            transform: rotate(10deg);
        }
    }
    
    @keyframes confetti-fall {
        0% {
            transform: translateY(-100%) rotate(0deg);
            opacity: 1;
        }
        100% {
            transform: translateY(100vh) rotate(720deg);
            opacity: 0;
        }
    }
    
    @keyframes balloon-float {
        0% {
            transform: translateY(100vh) rotate(0deg);
        }
        100% {
            transform: translateY(-100%) rotate(360deg);
        }
    }
    
    @keyframes star-twinkle {
        0%, 100% {
            opacity: 1;
            transform: scale(1);
        }
        50% {
            opacity: 0.5;
            transform: scale(1.2);
        }
    }
    
    .animate-bounce-in {
        animation: bounce-in 0.8s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    }
    
    .animate-bounce-slow {
        animation: bounce-slow 2s ease-in-out infinite;
    }
    
    .animate-fade-in {
        animation: fade-in 1s ease-out 0.3s both;
    }
    
    .animate-fade-in-delay {
        animation: fade-in 1s ease-out 0.6s both;
    }
    
    .animate-slide-up {
        animation: slide-up 1s ease-out 0.9s both;
    }
    
    .animate-pulse-slow {
        animation: pulse-slow 2s ease-in-out infinite;
    }
    
    .animate-shake {
        animation: shake 1s ease-in-out infinite;
    }
    
    /* Confetti */
    .confetti {
        position: absolute;
        width: 10px;
        height: 10px;
        background: #fff;
        animation: confetti-fall 3s linear infinite;
    }
    
    .confetti:nth-child(odd) {
        background: #FFD700;
    }
    
    .confetti:nth-child(3n) {
        background: #FF69B4;
    }
    
    .confetti:nth-child(4n) {
        background: #00CED1;
    }
    
    /* Balloons */
    .balloon {
        position: absolute;
        font-size: 3rem;
        animation: balloon-float 8s ease-in infinite;
    }
    
    .balloon-1 {
        animation-delay: 0s;
    }
    
    .balloon-2 {
        animation-delay: 1s;
    }
    
    .balloon-3 {
        animation-delay: 2s;
    }
    
    .balloon-4 {
        animation-delay: 3s;
    }
    
    .balloon-5 {
        animation-delay: 4s;
    }
    
    /* Stars */
    .stars {
        display: flex;
        justify-content: center;
        gap: 0.5rem;
    }
    
    .star {
        font-size: 2rem;
        animation: star-twinkle 1.5s ease-in-out infinite;
    }
    
    .star:nth-child(1) {
        animation-delay: 0s;
    }
    
    .star:nth-child(2) {
        animation-delay: 0.3s;
    }
    
    .star:nth-child(3) {
        animation-delay: 0.6s;
    }
    
    .star:nth-child(4) {
        animation-delay: 0.9s;
    }
    
    .star:nth-child(5) {
        animation-delay: 1.2s;
    }
</style>

<script>
    function closeBirthdayGreeting() {
        const greeting = document.getElementById('birthdayGreeting');
        greeting.style.animation = 'fade-out 0.5s ease-out';
        setTimeout(() => {
            greeting.remove();
        }, 500);
    }
    
    // Auto close after 15 seconds
    setTimeout(() => {
        const greeting = document.getElementById('birthdayGreeting');
        if (greeting) {
            closeBirthdayGreeting();
        }
    }, 15000);
</script>

<style>
    @keyframes fade-out {
        0% {
            opacity: 1;
        }
        100% {
            opacity: 0;
            transform: scale(0.8);
        }
    }
</style>
<?php endif; ?>
<?php /**PATH D:\LPKD-APJI\APJIKOM\resources\views/components/birthday-greeting.blade.php ENDPATH**/ ?>