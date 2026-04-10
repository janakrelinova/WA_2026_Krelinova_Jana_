
<?php require_once '../app/views/layout/header.php'; ?>
    <main class="container mx-auto px-6 py-12">
        <div class="max-w-4xl mx-auto">
            
            <div class="mb-10">
                <h2 class="text-4xl font-extrabold text-slate-950 tracking-tighter">Přidat novou knihu</h2>
                <p class="text-slate-500 text-lg mt-2">Vyplňte údaje a uložte knihu do databáze</p>
            </div>

            <div class="bg-white rounded-3xl border border-slate-100 shadow-2xl overflow-hidden">
                <form action="<?= BASE_URL ?>/index.php?url=book/store" method="post" enctype="multipart/form-data" class="p-8 md:p-12">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        
                        <div class="md:col-span-2">
                            <label for="title" class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">Název knihy <span class="text-brand">*</span></label>
                            <input type="text" id="title" name="title" required 
                                class="w-full px-5 py-4 rounded-xl border border-slate-200 focus:ring-4 focus:ring-brand-light focus:border-brand transition outline-none text-lg shadow-sm">
                        </div>

                        <div>
                            <label for="author" class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">Autor <span class="text-brand">*</span></label>
                            <input type="text" id="author" name="author" placeholder="Přijmení Jméno" required 
                                class="w-full px-5 py-4 rounded-xl border border-slate-200 focus:ring-4 focus:ring-brand-light focus:border-brand transition outline-none shadow-sm">
                        </div>

                        <div>
                            <label for="isbn" class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">ISBN <span class="text-brand">*</span></label>
                            <input type="text" id="isbn" name="isbn" required 
                                class="w-full px-5 py-4 rounded-xl border border-slate-200 focus:ring-4 focus:ring-brand-light focus:border-brand transition outline-none font-mono shadow-sm">
                        </div>

                        <div>
                            <label for="category" class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">Kategorie</label>
                            <input type="text" id="category" name="caregory" 
                                class="w-full px-5 py-4 rounded-xl border border-slate-200 focus:ring-4 focus:ring-brand-light focus:border-brand transition outline-none shadow-sm">
                        </div>

                        <div>
                            <label for="subcategory" class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">Podkategorie</label>
                            <input type="text" id="subcategory" name="subcategory" 
                                class="w-full px-5 py-4 rounded-xl border border-slate-200 focus:ring-4 focus:ring-brand-light focus:border-brand transition outline-none shadow-sm">
                        </div>

                        <div>
                            <label for="year" class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">Rok vydání <span class="text-brand">*</span></label>
                            <input type="number" id="year" name="year" required 
                                class="w-full px-5 py-4 rounded-xl border border-slate-200 focus:ring-4 focus:ring-brand-light focus:border-brand transition outline-none shadow-sm font-mono">
                        </div>

                        <div>
                            <label for="price" class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">Cena knihy (Kč)</label>
                            <input type="number" id="price" name="price" step="0.5" 
                                class="w-full px-5 py-4 rounded-xl border border-slate-200 focus:ring-4 focus:ring-brand-light focus:border-brand transition outline-none shadow-sm font-mono text-brand font-bold">
                        </div>

                        <div class="md:col-span-2">
                            <label for="link" class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">Externí odkaz</label>
                            <input type="text" id="link" name="link" placeholder="https://..."
                                class="w-full px-5 py-4 rounded-xl border border-slate-200 focus:ring-4 focus:ring-brand-light focus:border-brand transition outline-none shadow-sm">
                        </div>

                        <div class="md:col-span-2">
                            <label for="description" class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">Popis knihy</label>
                            <textarea name="description" id="description" rows="5" 
                                class="w-full px-5 py-4 rounded-xl border border-slate-200 focus:ring-4 focus:ring-brand-light focus:border-brand transition outline-none shadow-sm resize-none"></textarea>
                        </div>

                       <div class="md:col-span-2">
                        <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">
                            Obrázky knihy
                        </label>
                        
                        <div class="w-full">
                            <label for="images" class="flex flex-col items-center justify-center w-full h-32 border-2 border-slate-200 border-dashed rounded-2xl cursor-pointer bg-white hover:bg-brand-light hover:border-brand transition-all shadow-sm">
                                
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <span class="text-3xl mb-1 opacity-40 group-hover:opacity-100 transition">📸</span>
                                    
                                    <span id="file-title" class="text-sm text-slate-600 font-semibold transition-colors">
                                        Klikni pro výběr souborů
                                    </span>
                                    
                                    <span id="file-info" class="text-xs text-slate-400 mt-1 text-center px-4 tracking-tight">
                                        Žádné soubory nebyly vybrány
                                    </span>
                         </div>
            
            <input type="file" id="images" name="images[]" multiple accept="image/*" class="hidden">
        </label>
    </div>
</div>
                    </div>

                    <div class="mt-12 pt-8 border-t border-slate-100 flex justify-end">
                        <button type="submit" class="w-full md:w-auto bg-brand text-white px-10 py-4 rounded-xl font-extrabold text-lg hover:bg-brand-dark transition shadow-lg shadow-sky-100 flex items-center justify-center space-x-2 active:scale-95">
                            <span>💾</span>
                            <span>Uložit knihu do databáze</span>
                        </button>
                    </div>

                </form>
            </div>
            
            <p class="text-center text-slate-400 text-sm mt-8">Pole označená <span class="text-brand">*</span> jsou povinná.</p>
        </div>
    </main>

    <script>
    // Najdeme naše HTML prvky podle ID
    const fileInput = document.getElementById('images');
    const fileTitle = document.getElementById('file-title');
    const fileInfo = document.getElementById('file-info');

    // Posloucháme událost 'change'
    fileInput.addEventListener('change', function(event) {
        const files = event.target.files;
        
        if (files.length === 0) {
            // Uživatel výběr zrušil - vrátíme šedý design
            fileTitle.textContent = 'Klikni pro výběr souborů';
            fileTitle.className = 'text-sm text-slate-600 font-semibold group-hover:text-brand';
            fileInfo.textContent = 'JPG, PNG nebo WebP (vícenásobný výběr)';
            fileInfo.className = 'text-xs text-slate-400 mt-1';
        } else if (files.length === 1) {
            // Vybrán 1 soubor - zmodráme a ukážeme název
            fileTitle.textContent = 'Soubor připraven ✅';
            fileTitle.className = 'text-sm text-brand font-bold'; // Použije tvou modrou
            fileInfo.textContent = 'Vybráno: ' + files[0].name;
            fileInfo.className = 'text-xs text-brand-dark font-medium mt-1';
        } else {
            // Vybráno více souborů - zmodráme a ukážeme počet
            fileTitle.textContent = 'Soubory připraveny ✅';
            fileTitle.className = 'text-sm text-brand font-bold';
            fileInfo.textContent = 'Celkem vybráno: ' + files.length + ' obrázků';
            fileInfo.className = 'text-xs text-brand-dark font-medium mt-1';
        }
    });
</script>

<?php require_once '../app/views/layout/footer.php'; ?>
  