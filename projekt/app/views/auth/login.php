<div class="max-w-md mx-auto mt-20 bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
    <h2 class="text-3xl font-black text-gray-900 mb-2 text-center">Přihlášení</h2>
    <p class="text-gray-500 text-center mb-6 text-sm">Vítej zpět, zadej své údaje.</p>

    <form action="index.php?action=authenticate" method="POST" class="space-y-4">
        <div>
            <label class="block text-sm font-bold text-gray-700 mb-1">E-mail</label>
            <input type="email" name="email" required autofocus class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#14643a] focus:outline-none">
        </div>
        
        <div>
            <label class="block text-sm font-bold text-gray-700 mb-1">Heslo</label>
            <input type="password" name="password" required class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#14643a] focus:outline-none">
        </div>

        <button type="submit" class="w-full bg-[#14643a] text-white font-bold py-4 rounded-xl hover:bg-opacity-90 transition shadow-lg mt-4">
            Přihlásit se
        </button>
    </form>
    
    <p class="text-center mt-6 text-gray-500 text-sm">
        Ještě nemáš účet? <a href="index.php?action=register" class="text-[#14643a] font-bold">Zaregistruj se</a>
    </p>
</div>