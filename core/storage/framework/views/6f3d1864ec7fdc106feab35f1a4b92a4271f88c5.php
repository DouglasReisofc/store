

<?php $__env->startSection('content'); ?>

<style>
    .grid-card {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
    }

    .grid-item {
        flex: 0 0 calc(33.33% - 10px); /* ajustando para uma margem total de 10px */
        margin: 5px; /* margem de 5px em todos os lados */
    }

    .grid-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
    }

    .category-section {
        text-align: center;
        background-color: #d1d4df2e;
        padding: 10px;
        margin: 10px;
        border-radius: 10px;
        display: block;
    }

    .category-section.hidden {
        display: none;
    }

    .category-section h3 {
        font-size: 20px;
        color: #333;
        margin: 20px 0;
        position: relative;
        animation: rgbAnimation 2s infinite;
    }

    @keyframes  rgbAnimation {
        0% {
            color: red;
        }
        50% {
            color: green;
        }
        100% {
            color: blue;
        }
    }

    .card-item {
        border-radius: 10px; /* Adiciona cantos arredondados */
        padding: 3px;
    }

    .card-item .title {
        font-size: 10px;
        margin: 0px 0;
    }

    .card-item .title a {
        color: #1400ff;
        font-size: 8.5px;
    }

    .currency-value {
        color: #0bb316;
        font-weight: bold;
    }

    .card-details {
        color: #ff550d;
        font-weight: bold;
    }

    .card-thumb img {
        border: 2px solid #ccc; /* Adiciona uma borda à imagem */
        border-radius: 10px; /* Adiciona cantos arredondados à imagem */
        width: 100%; /* Ajusta o tamanho da imagem */
        max-width: 50px; /* Tamanho máximo para a versão PC */
    }

    .card-thumb {
        margin-bottom: 10px; /* Reduz o espaçamento entre a imagem e as informações abaixo */
    }

    .search-container {
        margin-bottom: 20px;
        position: relative;
        display: flex;
        align-items: center;
    }

    #searchInput {
        padding-left: 30px;
        width: 80%;
        margin: 0 auto;
        border-radius: 10px;
    }

    .search-icon {
        position: absolute;
        top: 50%;
        left: 10px;
        transform: translateY(-50%);
        cursor: pointer;
    }
</style>

<section class="latest-card-section <?php echo e(Auth::user() ? '' : 'pt-80 pb-80'); ?>">
    <div class="container">
        <div class="search-container">
            <span class="search-icon">&#128269;</span>
            <input type="text" id="searchInput" placeholder="Digite o que você procura" oninput="searchCards()">
        </div>
        <div class="card-wrapper grid-card">
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="category-section">
                    <h3><?php echo e($category->name); ?></h3>
                    <div class="row g-3 g-sm-4"> <!-- Ajuste para aplicar o espaçamento do grid do Bootstrap -->
                        <?php $__currentLoopData = $category->subCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subCategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <!-- Ajuste para as classes do grid do Bootstrap para controle de largura e exibição -->
                            <div class="col-md-7 col-lg-4 col-sm-7 grid-item card-item"> <!-- Ajuste para col-sm-4 para 3 itens por linha em sm -->
                                <div class="card-item">
                                    <?php if($subCategory->totalAvailableCards == 0): ?> <!-- Verifica se não há disponibilidade -->
                                        <div class="discount"></div> <!-- Adiciona a classe discount -->
                                    <?php endif; ?>
                                    <div class="card-thumb">
                                        <a href="<?php echo e(route('card.details', ['name'=>slug($subCategory->name), 'id'=>$subCategory->id])); ?>">
                                            <img src="<?php echo e(getImage(imagePath()['sub_category']['path'] . '/' . $subCategory->image)); ?>" alt="<?php echo e($subCategory->name); ?>" class="img-fluid">
                                        </a>
                                    </div>
                                    <h5 class="title">
                                        <a href="<?php echo e(route('card.details', ['name'=>slug($subCategory->name), 'id'=>$subCategory->id])); ?>">
                                            <?php echo e($subCategory->name); ?>

                                        </a>
                                    </h5>
                                    <br>
                                    <!-- Adicione a classe .card-details nos textos de Disponível e Valor -->
                                    <p class="card-details"><?php echo app('translator')->get('Disponível'); ?>: <span class="text--success"><?php echo e($subCategory->totalAvailableCards); ?></span></p>
                                    <p class="card-details"><?php echo app('translator')->get('Valor'); ?>: <span class="currency-value"><?php echo e($general->cur_sym); ?><?php echo e(number_format($subCategory->price, 2)); ?></span></p>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>

<script>
    function searchCards() {
        var input, filter, cards, card, a, i, txtValue;
        input = document.getElementById('searchInput');
        filter = input.value.toUpperCase();
        cards = document.getElementsByClassName('card-item');
        categories = document.getElementsByClassName('category-section');

        // Oculta todas as categorias e cards
        for (var i = 0; i < categories.length; i++) {
            categories[i].classList.add('hidden');
            var categoryCards = categories[i].getElementsByClassName('card-item');
            for (var j = 0; j < categoryCards.length; j++) {
                categoryCards[j].style.display = 'none';
            }
        }

        // Exibe subcategorias correspondentes no topo
        var matchingSubcategories = [];
        for (var i = 0; i < cards.length; i++) {
            card = cards[i];
            a = card.getElementsByTagName('h5')[0];
            txtValue = a.textContent || a.innerText;

            if (txtValue.toUpperCase().includes(filter)) {
                card.style.display = 'block';
                var categorySection = card.closest('.category-section');
                if (!matchingSubcategories.includes(categorySection)) {
                    matchingSubcategories.push(categorySection);
                }
            }
        }

        // Exibe subcategorias correspondentes no topo
        for (var k = 0; k < matchingSubcategories.length; k++) {
            matchingSubcategories[k].classList.remove('hidden');
        }

        // Exibe categorias e cards correspondentes
        for (i = 0; i < categories.length; i++) {
            var categoryCards = categories[i].getElementsByClassName('card-item');
            for (var j = 0; j < categoryCards.length; j++) {
                var cardName = categoryCards[j].getElementsByTagName('h5')[0].textContent.toUpperCase();
                if (cardName.includes(filter) && !matchingSubcategories.includes(categoryCards[j])) {
                    categoryCards[j].style.display = 'block';
                    categories[i].classList.remove('hidden');
                }
            }
        }
    }
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make($extends, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u153123621/domains/contas.club/public_html/core/resources/views/templates/basic/card.blade.php ENDPATH**/ ?>