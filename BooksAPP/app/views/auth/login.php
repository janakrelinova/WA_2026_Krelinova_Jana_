<?php require_once '../app/views/layout/header.php'; ?>

<main class="container mx-auto px-6 py-12 flex-grow flex items-center justify-center">
    <div class="w-full max-w-md">
        <div class="mb-8 text-center">
            <h2 class="text-3xl font-extrabold text-slate-950 tracking-tight">Přihlášení</h2>
            <p class="text-slate-500 mt-2">Vítejte zpět v naší Knihovně.</p>
        </div>
        
        <div class="bg-white border border-slate-200 rounded-2xl shadow-xl shadow-slate-100 p-8 md:p-10">
            <form action="<?= BASE_URL ?>/index.php?url=auth/authenticate" method="post">
                
                <div class="space-y-5">
                    <div>
                        <label for="email" class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wide">E-mail</label>
                        <input type="email" id="email" name="email" required autofocus
                               class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 text-slate-900 focus:outline-none focus:border-brand focus:ring-2 focus:ring-brand/10 transition-all">
                    </div>

                    <div>
                        <label for="password" class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wide">Heslo</label>
                        <input type="password" id="password" name="password" required 
                               class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2.5 text-slate-900 focus:outline-none focus:border-brand focus:ring-2 focus:ring-brand/10 transition-all">
                    </div>

                    <div class="pt-4">
                        <button type="submit" 
                                class="w-full bg-brand hover:bg-brand-dark text-white font-bold py-4 px-6 rounded-xl shadow-lg shadow-brand/20 transition-all uppercase tracking-widest text-sm">
                            Přihlásit se
                        </button>
                    </div>
                    
                    <div class="pt-6 border-t border-slate-100 text-center">
                        <p class="text-slate-500 text-sm">
                            Nemáte ještě účet? 
                            <a href="<?= BASE_URL ?>/index.php?url=auth/register" class="text-brand hover:text-brand-dark font-bold transition-colors underline underline-offset-4 ml-1">
                                Zaregistrujte se
                            </a>
                        </p>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>

<?php require_once '../app/views/layout/footer.php'; ?>