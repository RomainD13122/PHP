<main>
    <h1 style="text-align:center; color:#ff4d4d; margin:2.5rem 0; font-size:2.8rem;">Films à l’affiche</h1>

    <div class="movie-grid">
        <?php foreach ($movies as $m): ?>
            <div class="movie-card">
                <?php
                $poster = match (trim($m['title'])) {
                    'Chainsaw Man – Le Film : L’arc de Reze' => '/images/posters/cm.jpg',
                    'Jujutsu Kaisen 0'                       => '/images/posters/jjk.jpg',
                    'Demon Slayer: Kimetsu no Yaiba : La Forteresse infinie' => '/images/posters/ds.jpg',

                    'Dune: Part Two'              => 'https://fr.web.img4.acsta.net/pictures/24/01/26/10/18/5392835.jpg',
                    'Oppenheimer'                 => 'https://fr.web.img5.acsta.net/pictures/23/05/26/16/52/2793170.jpg',
                    'Poor Things'                 => 'https://image.tmdb.org/t/p/w500/kCGlIMHnOm8JPXq3rXM6c5wMxcT.jpg',
                    'Arcane'                      => 'https://fr.web.img5.acsta.net/img/4b/d4/4bd4ca11a3f044b29d94af060f32a61b.jpg',
                    'Un p\'tit truc en plus'      => 'https://i.ebayimg.com/images/g/T28AAOSwviVmTF5X/s-l1200.png',
                    'Les Tuche 4'                 => 'https://fr.web.img3.acsta.net/pictures/20/06/02/11/58/1908566.jpg',
                    'Le Comte de Monte-Cristo'    => 'https://m.media-amazon.com/images/I/61BkIzhaf3L._AC_UF1000,1000_QL80_.jpg',
                    'F1'                          => 'https://fr.web.img3.acsta.net/img/23/af/23afa3f5a87a13139d051786a37ee661.jpg',

                    default                       => 'https://picsum.photos/300/450?random=' . rand(1,1000)
                };
                ?>
                <img src="<?= $poster ?>" alt="<?= htmlspecialchars($m['title']) ?>" loading="lazy" crossorigin="anonymous" referrerpolicy="no-referrer" style="width:100%; height:340px; object-fit:cover;">

                <?php
                $badges = [
                    ['class' => 'new', 'text' => 'Nouveau'],
                    ['class' => 'fav', 'text' => 'Coup de Cœur']
                ];
                $badge = $badges[array_rand($badges)];
                ?>
                <span class="badge badge-<?= $badge['class'] ?>"><?= $badge['text'] ?></span>

                <div class="movie-info">
                    <h3><?= htmlspecialchars($m['title']) ?></h3>
                    <p><?= htmlspecialchars(substr($m['description'] ?? 'Pas de description disponible', 0, 70)) ?>...</p>
                    <a href="/movie/<?= $m['id'] ?>" class="btn-primary">Voir les séances</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</main>