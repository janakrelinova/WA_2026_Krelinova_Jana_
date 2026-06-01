<?php 
// Pomocné proměnné pro kontrolu práv (shodné s logikou učitele)
$isTripAuthor = (isset($_SESSION['user_id']) && $trip['user_id'] == $_SESSION['user_id']);
$isAdmin = (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1);
?>

<div class="max-w-4xl mx-auto mt-10 px-4">
    <a href="index.php" class="text-gray-400 hover:text-[#14643a] font-bold text-sm mb-6 inline-block">
        ← Zpět na všechny výlety
    </a>

    <div class="mb-8">
        <span class="text-[#14643a] font-black uppercase tracking-widest text-xs">
            <?php echo htmlspecialchars($trip['difficulty']); ?> náročnost
        </span>
        <h1 class="text-5xl font-black text-gray-900 mt-2"><?php echo htmlspecialchars($trip['title']); ?></h1>
        <p class="text-pink-500 font-bold mt-2">📍 <?php echo htmlspecialchars($trip['location']); ?></p>
    </div>

    <div class="rounded-3xl overflow-hidden shadow-2xl mb-10">
        <?php if (!empty($trip['image'])): ?>
            <img src="images/trips/<?php echo $trip['image']; ?>" class="w-full h-[500px] object-cover">
        <?php else: ?>
            <div class="w-full h-64 bg-gray-100 flex items-center justify-center text-gray-400 text-5xl">🌲</div>
        <?php endif; ?>
    </div>

    <?php if (!empty($trip['map_url'])): ?>
        <div class="mb-6">
            <a href="<?php echo $trip['map_url']; ?>" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 bg-[#14643a] text-white px-6 py-3 rounded-xl font-bold hover:bg-opacity-90 transition shadow-md text-sm">
                🗺️ Zobrazit trasu výletu na mapě
            </a>   
        </div>     
    <?php endif; ?>

    <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed">
        <p class="whitespace-pre-line">
            <?php echo htmlspecialchars($trip['description']); ?>
        </p>
    </div>

    <?php 
    // Nejdříve zjistíme, zda je uživatel vůbec přihlášený
    $isLoggedIn = isset($_SESSION['user_id']);
    
    // Práva spočítáme jen tehdy, pokud je přihlášený
    $isTripAuthor = $isLoggedIn && ($_SESSION['user_id'] == $trip['user_id']);
    $isAdmin = $isLoggedIn && (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1);

    // Podmínka: Ukážeme tlačítka pouze pokud je to autor NEBO admin
    if ($isTripAuthor || $isAdmin): 
    ?>
        <div class="mt-12 pt-8 border-t border-gray-100 flex gap-4">
            <a href="index.php?action=edit&id=<?php echo $trip['id']; ?>" class="bg-[#14643a] hover:bg-opacity-90 text-white px-6 py-2.5 rounded-xl font-bold transition shadow-md text-sm">
                ✏️ Upravit výlet
            </a>
            <a href="index.php?action=delete&id=<?php echo $trip['id']; ?>" onclick="return confirm('Opravdu chcete tento výlet trvale smazat?')" class="bg-gray-100 hover:bg-gray-200 text-gray-600 px-6 py-2.5 rounded-xl font-bold transition text-sm">
                🗑️ Smazat
            </a>
        </div>
    <?php endif; ?>
    </div>

<div class="max-w-4xl mx-auto mt-12 bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
    <h2 class="text-2xl font-black text-gray-900 mb-6">Komentáře k výletu</h2>

    <?php if (isset($_SESSION['user_id'])): ?>
        <form action="index.php?action=addComment" method="POST" class="mb-8">
            <input type="hidden" name="trip_id" value="<?php echo $trip['id']; ?>">
            <div class="mb-4">
                <textarea name="text" rows="3" required placeholder="Napiš svůj komentář nebo zážitek z výletu..." class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#14643a] focus:outline-none text-sm"></textarea>
            </div>
            <button type="submit" class="bg-[#14643a] text-white font-bold px-6 py-2.5 rounded-xl hover:bg-opacity-90 transition text-sm shadow-md">
                Odeslat komentář
            </button>
        </form>
    <?php else: ?>
        <p class="text-sm text-gray-500 mb-8 p-4 bg-gray-50 rounded-xl border border-gray-100">
            Pro přidávání komentářů se musíš nejprve <a href="index.php?action=login" class="text-[#14643a] font-bold">přihlásit</a>.
        </p>
    <?php endif; ?>

    <div class="space-y-4">
        <?php if (empty($comments)): ?>
            <p class="text-gray-400 text-sm text-center py-4">Zatím zde nejsou žádné komentáře. Buď první!</p>
        <?php else: ?>
            <?php foreach ($comments as $comment): ?>
                <?php 
                // Kontrola práv pro jednotlivé komentáře
                $isCommentAuthor = (isset($_SESSION['user_id']) && $comment['user_id'] == $_SESSION['user_id']);
                ?>
                <div class="bg-gray-50 p-5 rounded-2xl border border-gray-100 flex justify-between items-start">
                    <div class="space-y-1">
                        <div class="flex items-center gap-2">
                            <strong class="text-sm text-[#14643a]"><?php echo htmlspecialchars($comment['username']); ?></strong>
                            <span class="text-[11px] text-gray-400"><?php echo date('d.m.Y H:i', strtotime($comment['created_at'])); ?></span>
                        </div>
                        <p class="text-gray-700 text-sm leading-relaxed"><?php echo nl2br(htmlspecialchars($comment['text'])); ?></p>
                    </div>

                    <?php if ($isCommentAuthor || $isAdmin): ?>
                        <div class="flex items-center gap-2">
                            <?php if ($isCommentAuthor): ?>
                                <a href="index.php?action=editComment&id=<?php echo $comment['id']; ?>" class="text-gray-300 hover:text-blue-500 transition-colors p-1" title="Upravit komentář">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                </a>
                            <?php endif; ?>
                            
                            <a href="index.php?action=deleteComment&id=<?php echo $comment['id']; ?>" onclick="return confirm('Opravdu smazat komentář?')" class="text-gray-300 hover:text-red-500 transition-colors p-1" title="Smazat komentář">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>