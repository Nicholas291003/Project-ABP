<style>
    .brand-container {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .brand-text-global {
        font-size: 20px; 
        font-weight: 900;
        color: #1BA0E2; 
        letter-spacing: 1px;
        text-transform: uppercase;
        line-height: 1;
    }
</style>

<div class="brand-container">
    <h1 class="brand-text-global">TRAVELG</h1> 
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" class="w-5 h-5">
      <style>
        @keyframes shake {
          0%, 100% { transform: rotate(0deg) scale(1); }
          25% { transform: rotate(-15deg) scale(1.1); }
          50% { transform: rotate(0deg) scale(1); }
          75% { transform: rotate(15deg) scale(1.1); }
        }
        .star-logo {
          fill: #2dd4bf; /* Warna teal-400 standar Tailwind */
          transform-origin: center;
          animation: shake 1.5s infinite ease-in-out;
        }
      </style>
      <path class="star-logo" d="M50 0 L60 40 L100 50 L60 60 L50 100 L40 60 L0 50 L40 40 Z"/>
    </svg>
</div>

