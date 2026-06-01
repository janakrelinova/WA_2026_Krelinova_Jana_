<div class="max-w-2xl mx-auto mt-12 bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
    <h2 class="text-2xl font-black text-gray-800 mb-6">Upravit výlet: <?php echo htmlspecialchars($trip['title']); ?></h2>

    <form action="index.php?action=edit&id=<?php echo $trip['id']; ?>" method="POST" enctype="multipart/form-data" class="space-y-4">
        <div>
            <label class="block text-sm font-bold text-gray-700 mb-1">Název výletu</label>
            <input type="text" name="title" value="<?php echo htmlspecialchars($trip['title']); ?>" required class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#14643a] focus:outline-none">
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-700 mb-1">Lokalita</label>
            <input type="text" name="location" value="<?php echo htmlspecialchars($trip['location']); ?>" required class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#14643a] focus:outline-none">
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-700 mb-1">Odkaz na trasu (Mapy.cz, Google Maps...)</label>
            <input type="url" name="map_url" value="<?php echo htmlspecialchars($trip['map_url'] ?? ''); ?>" placeholder="https://mapy.cz/s/..." class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#14643a] focus:outline-none">
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-700 mb-1">Náročnost</label>
            <select name="difficulty" class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#14643a] focus:outline-none">
                <option value="lehká" <?php echo $trip['difficulty'] == 'lehká' ? 'selected' : ''; ?>>Lehká</option>
                <option value="střední" <?php echo $trip['difficulty'] == 'střední' ? 'selected' : ''; ?>>Střední</option>
                <option value="náročná" <?php echo $trip['difficulty'] == 'náročná' ? 'selected' : ''; ?>>Náročná</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-700 mb-1">Popis cesty</label>
            <textarea name="description" rows="4" class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#14643a] focus:outline-none"><?php echo htmlspecialchars($trip['description']); ?></textarea>
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-700 mb-1">Změnit fotku (nepovinné)</label>
            <?php if ($trip['image']): ?>
                <p class="text-xs text-gray-400 mb-2">Aktuální: <?php echo $trip['image']; ?></p>
            <?php endif; ?>
            <input type="file" name="image" accept="image/*" class="...">
        </div>

        <button type="submit" class="w-full bg-[#14643a] text-white font-bold py-3 rounded-xl shadow-lg mt-4">
            Uložit změny
        </button>
    </form>
</div>