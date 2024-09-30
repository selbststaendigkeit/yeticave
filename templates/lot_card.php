<li class="lots__item lot">
    <div class="lot__image">
        <img src="<?= htmlspecialchars($lot['image_url']) ?>" width="350" height="260" alt="<?= htmlspecialchars($lot['title']) ?>">
    </div>
    <div class="lot__info">
        <span class="lot__category"><?= htmlspecialchars($lot['category']) ?></span>
        <h3 class="lot__title"><a class="text-link" href="/lot.php?id=<?= intval($lot['id']) ?>"><?= htmlspecialchars($lot['title']) ?></a></h3>
        <div class="lot__state">
            <div class="lot__rate">
                <span class="lot__amount">Стартовая цена</span>
                <span class="lot__cost"><?= format_price_number(htmlspecialchars($lot['price'])); ?></span>
            </div>
            <?php $expiration_time = get_time_to_lot_expire(htmlspecialchars($lot['expiration_date'])); ?>
            <div class="lot__timer timer<?php if ($expiration_time[0] < 1): ?> timer--finishing<?php endif; ?>">
                <?= $expiration_time[0] ?>:<?= $expiration_time[1]; ?>
            </div>
        </div>
    </div>
</li>