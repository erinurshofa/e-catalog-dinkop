<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchQuery string */
/* @var $categoryId int */
/* @var $categories common\models\Categories[] */

$this->title = 'Katalog Produk UMKM';
$this->params['breadcrumbs'][] = $this->title;

// Custom CSS for premium catalog look
$this->registerCss("
    .catalog-hero {
        background: linear-gradient(135deg, #fdfbfb 0%, #ebedee 100%);
        padding: 4rem 2rem;
        border-radius: 1rem;
        margin-bottom: 3rem;
        box-shadow: 0 10px 30px rgba(0,0,0,0.02);
        text-align: center;
    }
    .catalog-hero h1 {
        font-weight: 700;
        font-size: 2.5rem;
        color: #1a1a1a;
        margin-bottom: 1rem;
        letter-spacing: -0.5px;
    }
    .catalog-hero p {
        color: #666;
        font-size: 1.1rem;
        max-width: 600px;
        margin: 0 auto 2rem;
    }
    .search-box {
        max-width: 700px;
        margin: 0 auto;
        position: relative;
    }
    .search-input {
        width: 100%;
        padding: 1.2rem 1.5rem 1.2rem 3.5rem;
        font-size: 1.1rem;
        border: 2px solid #fff;
        border-radius: 50px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.06);
        transition: all 0.3s ease;
        background: #fff;
    }
    .search-input:focus {
        outline: none;
        border-color: #4a90e2;
        box-shadow: 0 8px 30px rgba(74, 144, 226, 0.15);
    }
    .search-icon {
        position: absolute;
        left: 1.5rem;
        top: 50%;
        transform: translateY(-50%);
        color: #999;
        font-size: 1.2rem;
    }
    .search-btn {
        position: absolute;
        right: 0.5rem;
        top: 50%;
        transform: translateY(-50%);
        background: #1a1a1a;
        color: #fff;
        border: none;
        padding: 0.8rem 1.5rem;
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.2s;
    }
    .search-btn:hover {
        background: #333;
        transform: translateY(-50%) scale(1.02);
    }
    
    .category-sidebar {
        background: #fff;
        border-radius: 1rem;
        padding: 1.5rem;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        position: sticky;
        top: 2rem;
    }
    .category-title {
        font-weight: 700;
        font-size: 1.2rem;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #f0f0f0;
    }
    .category-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .category-list li {
        margin-bottom: 0.5rem;
    }
    .category-link {
        display: block;
        padding: 0.6rem 1rem;
        color: #555;
        text-decoration: none;
        border-radius: 0.5rem;
        transition: all 0.2s;
        font-weight: 500;
    }
    .category-link:hover, .category-link.active {
        background: #f8f9fa;
        color: #1a1a1a;
        padding-left: 1.5rem;
    }
    .category-link.active {
        background: #1a1a1a;
        color: #fff;
    }

    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 2rem;
    }
    .product-card {
        background: #fff;
        border-radius: 1rem;
        overflow: hidden;
        border: none;
        box-shadow: 0 4px 15px rgba(0,0,0,0.04);
        transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        display: flex;
        flex-direction: column;
        height: 100%;
        position: relative;
    }
    .product-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    }
    .product-img-wrapper {
        position: relative;
        padding-top: 100%; /* 1:1 Aspect Ratio */
        overflow: hidden;
        background: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .product-img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    .product-card:hover .product-img {
        transform: scale(1.05);
    }
    .product-badge {
        position: absolute;
        top: 1rem;
        right: 1rem;
        background: rgba(255,255,255,0.9);
        backdrop-filter: blur(4px);
        padding: 0.3rem 0.8rem;
        border-radius: 50px;
        font-size: 0.8rem;
        font-weight: 600;
        color: #1a1a1a;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        z-index: 10;
    }
    .product-info {
        padding: 1.5rem;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }
    .product-category {
        color: #888;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.5rem;
        font-weight: 600;
    }
    .product-title {
        font-weight: 700;
        font-size: 1.1rem;
        line-height: 1.4;
        margin-bottom: 1rem;
        color: #1a1a1a;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .product-footer {
        margin-top: auto;
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
    }
    .product-price {
        font-weight: 800;
        font-size: 1.25rem;
        color: #4a90e2;
    }
    .product-umkm {
        font-size: 0.8rem;
        color: #777;
        margin-bottom: 0.2rem;
    }
    
    .empty-state {
        text-align: center;
        padding: 5rem 2rem;
        background: #fff;
        border-radius: 1rem;
        box-shadow: 0 4px 15px rgba(0,0,0,0.02);
    }
    .empty-state i {
        font-size: 4rem;
        color: #ddd;
        margin-bottom: 1rem;
    }
    .empty-state h3 {
        font-weight: 600;
        color: #333;
    }

    /* Premium Pagination */
    .catalog-pagination {
        margin-top: 4rem;
        display: flex;
        justify-content: center;
    }
    .catalog-pagination .pagination {
        background: #fff;
        padding: 0.5rem;
        border-radius: 50px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        gap: 0.2rem;
    }
    .catalog-pagination .page-item .page-link {
        border: none;
        color: #555;
        font-weight: 600;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        margin: 0 2px;
        transition: all 0.2s;
        background: transparent;
    }
    .catalog-pagination .page-item .page-link:hover {
        background: #f0f0f0;
        color: #1a1a1a;
    }
    .catalog-pagination .page-item.active .page-link {
        background: #1a1a1a;
        color: #fff;
        box-shadow: 0 4px 10px rgba(26,26,26,0.2);
    }
    .catalog-pagination .page-item.disabled .page-link {
        color: #ccc;
        background: transparent;
    }
    
    @media (max-width: 768px) {
        .catalog-hero {
            padding: 3rem 1.5rem;
        }
        .catalog-hero h1 {
            font-size: 2rem;
        }
        .search-btn {
            position: static;
            width: 100%;
            transform: none;
            margin-top: 1rem;
        }
        .search-input {
            border-radius: 50px;
        }
    }
");

?>
<div class="catalog-default-index container py-4">

    <!-- Hero Section with Search -->
    <div class="catalog-hero">
        <h1>Temukan Produk Lokal Terbaik</h1>
        <p>Dukung UMKM sekitar dengan berbelanja produk berkualitas tinggi, unik, dan asli buatan anak bangsa.</p>
        
        <form action="<?= Url::to(['/catalog/default/index']) ?>" method="get" class="search-box">
            <!-- Hidden input for route to survive GET form submission when pretty URLs are disabled -->
            <input type="hidden" name="r" value="catalog/default/index">
            <i class="fas fa-search search-icon"></i>
            <input type="text" name="q" class="search-input" placeholder="Cari berdasarkan nama produk..." value="<?= Html::encode($searchQuery) ?>">
            <?php if ($categoryId): ?>
                <input type="hidden" name="category_id" value="<?= $categoryId ?>">
            <?php endif; ?>
            <button type="submit" class="search-btn">Temukan</button>
        </form>
    </div>

    <div class="row">
        <!-- Sidebar Categories -->
        <div class="col-lg-3 mb-4">
            <div class="category-sidebar">
                <h4 class="category-title">Kategori</h4>
                <ul class="category-list">
                    <li>
                        <a href="<?= Url::to(['/catalog/default/index', 'q' => $searchQuery]) ?>" 
                           class="category-link <?= empty($categoryId) ? 'active' : '' ?>">
                           Semua Produk
                        </a>
                    </li>
                    <?php foreach ($categories as $cat): ?>
                        <li>
                            <a href="<?= Url::to(['/catalog/default/index', 'category_id' => $cat->id, 'q' => $searchQuery]) ?>" 
                               class="category-link <?= $categoryId == $cat->id ? 'active' : '' ?>">
                               <?= Html::encode($cat->name) ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>

        <!-- Main Product Grid -->
        <div class="col-lg-9">
            <?php if ($dataProvider->getCount() > 0): ?>
                <div class="product-grid">
                    <?php foreach ($dataProvider->getModels() as $product): ?>
                        <div class="product-card">
                            <?php 
                                $primaryImage = null;
                                if (!empty($product->productImages)) {
                                    foreach ($product->productImages as $img) {
                                        if ($img->is_primary) {
                                            $primaryImage = $img->image_path;
                                            break;
                                        }
                                    }
                                    if (!$primaryImage) {
                                        $primaryImage = $product->productImages[0]->image_path;
                                    }
                                } else {
                                    $primaryImage = 'https://via.placeholder.com/600x600?text=No+Image';
                                }
                            ?>
                            <div class="product-img-wrapper">
                                <img src="<?= Html::encode($primaryImage) ?>" alt="<?= Html::encode($product->name) ?>" class="product-img" loading="lazy">
                                <?php if ($product->is_featured): ?>
                                    <div class="product-badge"><i class="fas fa-star text-warning"></i> Unggulan</div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="product-info">
                                <div class="product-category"><?= $product->category ? Html::encode($product->category->name) : 'Tanpa Kategori' ?></div>
                                <h3 class="product-title">
                                    <a href="<?= Url::to(['/catalog/default/detail', 'slug' => $product->slug]) ?>" class="text-decoration-none text-dark stretched-link">
                                        <?= Html::encode($product->name) ?>
                                    </a>
                                </h3>
                                
                                <div class="product-footer">
                                    <div>
                                        <div class="product-umkm"><i class="fas fa-store text-muted me-1"></i> <?= $product->umkmProfile ? Html::encode($product->umkmProfile->nama_usaha) : '-' ?></div>
                                        <div class="product-price">Rp <?= number_format($product->price, 0, ',', '.') ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Pagination -->
                <div class="catalog-pagination">
                    <?= LinkPager::widget([
                        'pagination' => $dataProvider->pagination,
                        'options' => ['class' => 'pagination mb-0'],
                        'prevPageCssClass' => 'page-item',
                        'nextPageCssClass' => 'page-item',
                        'pageCssClass' => 'page-item',
                        'activePageCssClass' => 'active',
                        'disabledPageCssClass' => 'disabled',
                        'linkOptions' => ['class' => 'page-link'],
                        'prevPageLabel' => '<i class="fas fa-chevron-left"></i>',
                        'nextPageLabel' => '<i class="fas fa-chevron-right"></i>',
                        'maxButtonCount' => 5,
                    ]) ?>
                </div>

            <?php else: ?>
                <!-- Empty State -->
                <div class="empty-state">
                    <i class="fas fa-box-open"></i>
                    <h3>Belum ada produk</h3>
                    <p class="text-muted">Maaf, kami tidak menemukan produk yang sesuai dengan pencarian Anda.</p>
                    <?php if (!empty($searchQuery) || !empty($categoryId)): ?>
                        <a href="<?= Url::to(['/catalog/default/index']) ?>" class="btn btn-outline-dark mt-3 rounded-pill px-4">Lihat Semua Produk</a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
