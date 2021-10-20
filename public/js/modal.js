$(document).on('click', '.product-name', function(){
    let producSelector = $(this).parent().parent();
    showModal();
    dataModalFiller(producSelector);
})

$(document).on('click', '.modal-close', closeModal);

function dataModalFiller(productSelector){
    let name = productSelector.find('.product-name').text();
    let description = productSelector.find('.product-description').text();
    let imageURI = getRandomImageURI();

    $('.modal-name').text(name);
    $('.modal-description').text(description);
    $('.modal-img').attr('src', imageURI);
}

function getRandomImageURI(){
    let randomImage = Math.ceil(Math.random()*100);
    return 'https://picsum.photos/id/'+randomImage+'/400';
}

function showModal(){
    $('.product-modal').css('display','flex');
}

function closeModal(){
    $('.product-modal').hide();
}