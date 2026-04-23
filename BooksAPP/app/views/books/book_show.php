<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail knihy: <?= htmlspecialchars($book['title'] ?? 'Neznámý titul') ?></title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; line-height: 1.6; color: #333; background-color: #f4f4f9; padding: 20px; }
        .container { max-width: 800px; margin: 0 auto; background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1 { color: #2c3e50; border-bottom: 2px solid #eee; padding-bottom: 10px; }
        .back-link { display: inline-block; margin-bottom: 20px; color: #3498db; text-decoration: none; font-weight: bold; }
        .back-link:hover { text-decoration: underline; }
        .info-group { margin-top: 20px; }
        p { margin: 10px 0; font-size: 1.1em; }
        .label { font-weight: bold; color: #7f8c8d; min-width: 120px; display: inline-block; }
        .description-box { background: #f9f9f9; padding: 15px; border-left: 4px solid #3498db; margin-top: 10px; font-style: italic; }
        
        /* Stylování obrázků */
        .image-gallery { display: flex; gap: 15px; flex-wrap: wrap; margin: 20px 0; }
        .image-card { border: 1px solid #ddd; padding: 5px; border-radius: 5px; background: #fff; }
        .image-card img { max-width: 200px; height: auto; display: block; border-radius: 3px; }
        .no-image { color: #999; font-style: italic; }
    </style>
</head>
<body>

<div class="container">
    <a href="<?= BASE_URL ?>/index.php" class="back-link">&larr; Zpět na seznam knih</a>

    <h1><?= htmlspecialchars($book['title'] ?? 'Bez názvu') ?></h1>

    <div class="info-group">
        <p><span class="label">Autor:</span> <?= htmlspecialchars($book['author'] ?? 'Neuvedeno') ?></p>
        <p><span class="label">Kategorie:</span> <?= htmlspecialchars($book['category'] ?? 'Neuvedeno') ?></p>
        <p><span class="label">Podkategorie:</span> <?= htmlspecialchars($book['subcategory'] ?? 'Neuvedeno') ?></p>
        <p><span class="label">Rok vydání:</span> <?= htmlspecialchars($book['year'] ?? '-') ?></p>
        <p><span class="label">Cena:</span> <strong><?= htmlspecialchars($book['price'] ?? '0') ?> Kč</strong></p>
        <p><span class="label">ISBN:</span> <?= htmlspecialchars($book['isbn'] ?? '-') ?></p>
        
        <p><span class="label">Web:</span> 
            <?php if (!empty($book['link'])): ?>
                <a href="<?= htmlspecialchars($book['link']) ?>" target="_blank">Otevřít odkaz</a>
            <?php else: ?>
                <span class="no-image">Není k dispozici</span>
            <?php endif; ?>
        </p>

        <h3>Obrázky</h3>
        <div class="image-gallery">
            <?php 
            $images = [];
            if (!empty($book['images'])) {
                // Dekódování JSONu z databáze na pole
                $images = is_array($book['images']) ? $book['images'] : json_decode($book['images'], true);
            }

            if (!empty($images) && is_array($images)): 
                foreach ($images as $imgName): ?>
                    <div class="image-card">
                        <img src="<?= BASE_URL ?>/uploads/<?= htmlspecialchars($imgName) ?>" alt="Náhled knihy">
                    </div>
                <?php endforeach; 
            else: ?>
                <p class="no-image">K této knize nejsou nahrány žádné obrázky.</p>
            <?php endif; ?>
        </div>

        <h3>Popis knihy</h3>
        <div class="description-box">
            <?= nl2br(htmlspecialchars($book['description'] ?? 'Popis chybí.')) ?>
        </div>
    </div>
</div>

</body>
</html>