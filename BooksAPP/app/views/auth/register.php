<?php if (isset($_SESSION['messages'])): ?>
    <div class="notifications" style="margin-bottom: 20px;">
        
        <?php if (!empty($_SESSION['messages']['error'])): ?>
            <?php foreach ($_SESSION['messages']['error'] as $error): ?>
                <div style="background-color: #f8d7da; color: #721c24; padding: 10px; border: 1px solid #f5c6cb; border-radius: 4px; margin-bottom: 5px;">
                    <strong>Chyba:</strong> <?= htmlspecialchars($error) ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <?php if (!empty($_SESSION['messages']['success'])): ?>
            <?php foreach ($_SESSION['messages']['success'] as $success): ?>
                <div style="background-color: #d4edda; color: #155724; padding: 10px; border: 1px solid #c3e6cb; border-radius: 4px; margin-bottom: 5px;">
                    <strong>Úspěch:</strong> <?= htmlspecialchars($success) ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

    </div>

    <?php unset($_SESSION['messages']); ?>
<?php endif; ?>
<?php require_once '../app/views/layout/header.php'; ?>

<main class="container mx-auto px-6 py-12 flex-grow flex items-center justify-center">
    <div class="w-full max-w-2xl">
        <div class="mb-8 text-center">
            <h2 class="text-3xl font-extrabold text-slate-950 tracking-tight">Nová registrace</h2>
            <p class="text-slate-500 mt-2">Vytvořte si účet pro správu vašeho knižního katalogu.</p>
        </div>
        
        <div class="bg-white border border-slate-200 rounded-2xl shadow-xl shadow-slate-100 p-8 md:p-10">
            <form action="<?= BASE_URL ?>/index.php?url=auth/storeUser" method="post">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5">
                    
                    <div class="md:col-span-2">
                        <h3 class="text-brand font-bold text-sm uppercase tracking-wider border-b border-slate-100 pb-2 mb-2">Přihlašovací údaje</h3>
                    </div>

                    <div>
                        <label for="username" class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wide">Uživatelské jméno <span class="text-rose-500">*</span></label>
                        <input type="text" id="username" name="username" required 
                               class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 text-slate-900 focus:outline-none focus:border-brand focus:ring-2 focus:ring-brand/10 transition-all">
                    </div>

                    <div>
                        <label for="email" class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wide">E-mail <span class="text-rose-500">*</span></label>
                        <input type="email" id="email" name="email" required 
                               class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 text-slate-900 focus:outline-none focus:border-brand focus:ring-2 focus:ring-brand/10 transition-all">
                    </div>

                    <div>
                        <label for="password" class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wide">Heslo <span class="text-rose-500">*</span></label>
                        <input type="password" id="password" name="password" required 
                               class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 text-slate-900 focus:outline-none focus:border-brand focus:ring-2 focus:ring-brand/10 transition-all">
                    </div>

                    <div>
                        <label for="password_confirm" class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wide">Potvrzení hesla <span class="text-rose-500">*</span></label>
                        <input type="password" id="password_confirm" name="password_confirm" required 
                               class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 text-slate-900 focus:outline-none focus:border-brand focus:ring-2 focus:ring-brand/10 transition-all">
                    </div>

                    <div class="md:col-span-2 mt-6">
                        <h3 class="text-brand font-bold text-sm uppercase tracking-wider border-b border-slate-100 pb-2 mb-2">Osobní údaje <span class="text-slate-400 font-normal normal-case italic">(Volitelné)</span></h3>
                    </div>

                    <div>
                        <label for="first_name" class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wide">Křestní jméno</label>
                        <input type="text" id="first_name" name="first_name" 
                               class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 text-slate-900 focus:outline-none focus:border-brand focus:ring-2 focus:ring-brand/10 transition-all">
                    </div>

                    <div>
                        <label for="last_name" class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wide">Příjmení</label>
                        <input type="text" id="last_name" name="last_name" 
                               class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 text-slate-900 focus:outline-none focus:border-brand focus:ring-2 focus:ring-brand/10 transition-all">
                    </div>

                    <div class="md:col-span-2">
                        <label for="nickname" class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wide">Zobrazovaná přezdívka</label>
                        <input type="text" id="nickname" name="nickname" placeholder="Jak vám máme v aplikaci říkat?"
                               class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 text-slate-900 placeholder-slate-400 focus:outline-none focus:border-brand focus:ring-2 focus:ring-brand/10 transition-all">
                    </div>

                    <div class="md:col-span-2 mt-8">
                        <button type="submit" 
                                class="w-full bg-brand hover:bg-brand-dark text-white font-bold py-4 px-6 rounded-xl shadow-lg shadow-brand/20 transition-all uppercase tracking-widest text-sm">
                            Vytvořit účet
                        </button>
                        
                        <p class="text-center text-slate-500 text-sm mt-6">
                            Už máte účet? <a href="<?= BASE_URL ?>/index.php?url=auth/login" class="text-brand hover:text-brand-dark font-bold transition-colors underline underline-offset-4">Přihlaste se zde</a>.
                        </p>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>

<?php require_once '../app/views/layout/footer.php'; ?>