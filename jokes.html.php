<?php foreach ($jokes as $joke): ?>
  <blockquote>
    <p><?= nl2br(htmlspecialchars($joke['joketext'], ENT_QUOTES, 'UTF-8')) ?></p>
    
    <?php if (!empty($joke['image_path'])): ?>
        <div class="joke-image">
            <img src="images/<?= htmlspecialchars($joke['image_path'], ENT_QUOTES, 'UTF-8') ?>" 
                 alt="Joke Image" 
                 style="max-width: 300px; height: auto; margin: 10px 0; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.2);">
        </div>
    <?php endif; ?>

    <form action="deletejoke.php" method="post">
      <input type="hidden" name="id" value="<?= (int)$joke['id'] ?>">
      <input type="submit" value="Delete">
    </form>
  </blockquote>
<?php endforeach; ?>