/**
 * Created by wcorc on 24/04/2017.
 */

var cartCounterApp = new Vue({
    el: '#cartCounterApp',
    data: {
        recipes: []
    },
});

$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var $buttons = $('.actionAddToCart');
    $buttons.click(function (evt) {
        evt.preventDefault();
        var $this = $(this);
        if ($this.find('.glyphicon-plus').length > 0) {
            addRecipeToCart($this.data('recipe-id'));
            $this.find('.glyphicon-plus').removeClass('glyphicon-plus').addClass('glyphicon-minus');
        } else {
            removeRecipeFromCart($this.data('recipe-id'));
            $this.find('.glyphicon-minus').removeClass('glyphicon-minus').addClass('glyphicon-plus');
        }

    });

    $.get('/cart/getRecipesInCart', function (data) {
        console.log(typeof(data), data);
        if (typeof(data) == 'object') {
            $.each(data, function (i, item) {
                cartCounterApp.$data.recipes.push(item);
                $buttons.filter('[data-recipe-id=' + item + ']').find('.glyphicon-plus')
                    .removeClass('glyphicon-plus').addClass('glyphicon-minus');
            });
        }
    });

});

var addRecipeToCart = function (id) {
    cartCounterApp.$data.recipes.push("" + id);
    $.post('/cart/addToCar', {id: id});
};

var removeRecipeFromCart = function (id) {
    var i = $.inArray("" + id, cartCounterApp.$data.recipes);
    if (i > -1) {
        cartCounterApp.$data.recipes.splice(i, 1);
        $.post('/cart/removeFromCart', {id: id});
    }
}