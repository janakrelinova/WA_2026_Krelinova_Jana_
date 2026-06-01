<div class="flex flex-col md:flex-row justify-between items-center mb-12 gap-6 w-full">
    
    <h1 class="text-4xl font-black text-gray-900 tracking-tight whitespace-nowrap">
        Tipy na <span class="text-[#14643a]">výlet</span>
    </h1>

    <div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-center gap-4">
        <form action="index.php" method="GET" class="flex items-center gap-3 w-full sm:w-auto">
            <input type="hidden" name="action" value="index"> 
            
            <label for="difficulty" class="text-sm font-bold text-gray-700 whitespace-nowrap">Filtrovat podle obtížnosti:</label>
            
            <select name="difficulty" id="difficulty" class="px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#14643a] focus:outline-none text-sm bg-gray-50 font-medium">
                <option value="">-- Všechny obtížnosti --</option>
                <option value="lehká" <?php echo (isset($_GET['difficulty']) && $_GET['difficulty'] === 'lehká') ? 'selected' : ''; ?>>Lehká 🟢</option>
                <option value="střední" <?php echo (isset($_GET['difficulty']) && $_GET['difficulty'] === 'střední') ? 'selected' : ''; ?>>Střední 🟡</option>
                <option value="náročná" <?php echo (isset($_GET['difficulty']) && $_GET['difficulty'] === 'náročná') ? 'selected' : ''; ?>>Náročná 🔴</option>
            </select>
            
            <button type="submit" class="bg-[#14643a] text-white px-4 py-2 rounded-xl font-bold hover:bg-opacity-90 transition text-sm shadow-sm">
                Filtrovat
            </button>
            
            <?php if (!empty($_GET['difficulty'])): ?>
                <a href="index.php" class="text-gray-500 hover:text-gray-700 text-sm font-medium underline pl-2 whitespace-nowrap">
                    Zrušit filtr
                </a>
            <?php endif; ?>
        </form>
    </div>
    
    <a href="index.php?action=create" class="bg-[#14643a] text-white px-8 py-3 rounded-full font-bold hover:scale-105 transition-transform shadow-lg flex items-center gap-2 whitespace-nowrap">
        <span class="text-xl">+</span> Přidat výlet
    </a>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
    
    <?php foreach ($trips as $trip): ?>
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-2xl transition-all duration-300 flex flex-col h-full">
            
            <div class="relative w-full h-56 bg-gray-100 overflow-hidden">
                <?php if (!empty($trip['image'])): ?>
                    <img src="images/trips/<?php echo $trip['image']; ?>" 
                         alt="<?php echo htmlspecialchars($trip['title']); ?>" 
                         class="w-full h-full object-cover">
                <?php else: ?>
                    <div class="w-full h-full flex flex-col items-center justify-center text-gray-400">
                        <span class="text-4xl mb-2">🌲</span>
                        <span class="text-xs font-bold uppercase tracking-widest">Bez fotky</span>
                    </div>
                <?php endif; ?>
            </div>

            <div class="p-8 flex flex-col flex-grow">
                <div class="mb-4">
                    <span class="px-3 py-1 bg-green-50 text-[#14643a] text-[10px] font-black uppercase tracking-widest rounded-full border border-green-100">
                        <?php echo htmlspecialchars($trip['difficulty']); ?>
                    </span>
                </div>

                <h3 class="text-2xl font-bold text-gray-800 mb-3 leading-tight hover:text-[#14643a] transition-colors">
                    <a href="index.php?action=show&id=<?php echo $trip['id']; ?>">
                        <?php echo htmlspecialchars($trip['title']); ?>
                    </a>
                </h3>

                <p class="text-gray-500 text-sm mb-6 line-clamp-3 flex-grow leading-relaxed">
                    <?php echo htmlspecialchars($trip['description']); ?>
                </p>

                <div class="pt-5 border-t border-gray-50 flex justify-between items-center">
                    <div class="flex items-center text-pink-500 font-bold text-[12px] uppercase tracking-wider">
                        <span class="mr-1 text-lg">📍</span>
                        <?php echo htmlspecialchars($trip['location']); ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

</div>