<div class="max-w-2xl mx-auto mt-12 bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
    <h2 class="text-2xl font-black text-gray-800 mb-6">Přidej tip na výlet</h2>

    <form action="index.php?action=create" method="POST" enctype="multipart/form-data" class="space-y-4">
        
        <div>
            <label class="block text-sm font-bold text-gray-700 mb-1">Název výletu</label>
            <input type="text" name="title" required class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#14643a] focus:outline-none">
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-700 mb-1">Lokalita</label>
            <input type="text" name="location" required class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#14643a] focus:outline-none">
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-700 mb-1">Odkaz na trasu (Mapy.cz, Google Maps...)</label>
            <input type="url" name="map_url" placeholder="https://mapy.cz/s/..." class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#14643a] focus:outline-none">
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-700 mb-1">Náročnost</label>
            <select name="difficulty" class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#14643a] focus:outline-none">
                <option value="lehká">Lehká</option>
                <option value="střední">Střední</option>
                <option value="náročná">Náročná</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-700 mb-1">Popis cesty</label>
            <textarea name="description" rows="4" class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#14643a] focus:outline-none"></textarea>
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-700 mb-1">Fotky z výletu</label>
            <input type="file" name="image" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-[#14643a] file:text-white hover:file:bg-opacity-90">
        </div>

        <button type="submit" class="w-full bg-[#14643a] text-white font-bold py-3 rounded-xl hover:bg-opacity-90 transition shadow-lg mt-4">
            Uložit výlet do deníku
        </button>

    </form> </div>