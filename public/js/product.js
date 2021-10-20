$(document).on('change', '.product-per-page', function(){
    let productPerPage = $(this).val();
    let urn = "/product/"+productPerPage+"/1";
    document.location.href = urn;
})

$(document).on('change, keyup', '.product-search-bar', function(){
    let inputValue = $(this).val();

    //little trick to not to implement basic symfony listing and pagination when clear search bar
    if(inputValue.length == 0)
        location.reload();

    if(inputValue.length < 3)
        return;

    $.ajax({
        url: '/search/'+inputValue,
        method: 'GET',
        dataType: 'json',
    }).done(function(data){
        renderFetchedProducts(data);
    }).fail(function(err){
        console.log(err);
    });
})

function renderFetchedProducts(products){
    remvoeAndClearBlocks();
    products.forEach(product => {
        let productHTML = prepareProductHTML(product);
        $('.product-container').append(productHTML);
    });
}

function remvoeAndClearBlocks(){
    $('.product-footer').remove();
    $('.product-container').empty();
}

function prepareProductHTML(product){
    let currency = $('.currency').val();
    let priceBlock = ``;
    
    if(product.discount > 0)
        priceBlock = ` <span class="product-price discount">`+product.price+`</span>
            <span class="product-discount">`+product.discount+`</span>`;
    else
        priceBlock = `<span class="product-price">`+product.price+`</span>`;

    let productHtml = `<div class="product" data-id="`+product.id+`">
        <div class="product-header">
            <span class="product-id">`+product.id+`</span>
            <span class="product-sku">`+product.sku+`</span>
        </div>
        <div class="product-body">
            <span class="product-name">`+product.name+`</span>
            <span class="product-description">`+product.description+`</span>
        </div>
        <div class="product-footer">
            `+priceBlock+currency+`
        </div>
    </div>`

    return productHtml;
}