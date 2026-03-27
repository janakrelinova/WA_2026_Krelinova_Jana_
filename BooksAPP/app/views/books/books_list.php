<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Knihovna - Seznam knih</title>
</head>
<body>
    <header>
        <h1>Aplikace Knihovna</h1>
        
     <nav>
        <ul>
            <li><a href="<?= BASE_URL ?>/index.php">Seznam knih (Domů)</a></li>
            <li><a href="<?= BASE_URL ?>/index.php?url=book/create">Přidat novou knihu</a></li>
        </ul>
    </nav>
       

    </header>

    <main>
        <h2>Dostupné knihy</h2>
        
        <?php if (!empty($books)): ?>
            <table border="1" style="width:100%; border-collapse: collapse;">
                <thead>
                    <tr style="background-color: #f2f2f2;">
                        <th>Název</th>
                        <th>Autor</th>
                        <th>ISBN</th>
                        <th>Rok vydání</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($books as $book): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($book['title']); ?></td>
                            <td><?php echo htmlspecialchars($book['author']); ?></td>
                            <td><?php echo htmlspecialchars($book['isbn']); ?></td>
                            <td><?php echo htmlspecialchars($book['year']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>V databázi zatím nejsou žádné knihy nebo tabulka neexistuje.</p>
        <?php endif; ?>

    </main>

    
    <footer>
        <p>&copy; WA 2026 - výukový projekt</p>
    </footer>
</body>
</html>