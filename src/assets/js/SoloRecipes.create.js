/**
 * Created by wcorc on 17/04/2017.
 */
var app2 = new Vue({
    el: '#app-4',
    data: {
        ingredients: []
    },
    methods:{
        removeElement:function(i){
            this.$data.ingredients.splice(i, 1);
        }
    }
});
var steps = new Vue({
    el: '#stepsContainer',
    data: {
        steps: []
    },
    methods:{
        removeElement:function(i){
            this.$data.steps.splice(i, 1);
        },
        addStep:function(){
            this.$data.steps.push({});
        }
    }
});
$(function(){
    if(typeof (currIngredients) != 'undefined' && currIngredients.length > 0){
        $.each(currIngredients,function(i,item){
            app2.$data.ingredients.push(item);
        });
    }

    if(typeof (currSteps) != 'undefined' && currSteps.length > 0){
        $.each(currSteps,function(i,item){
            steps.$data.steps.push(item);
        });
    }

    $('#searchlist').btsListFilter('#searchinput', {
        loadingClass: 'loading',
        sourceTmpl: '<a class="list-group-item" data-id="{id}" data-name="{name}"><span>{name}</span></a>',
        sourceData: function(text, callback) {
            return $.getJSON('/ingredients/search/'+text, function(json) {
                callback(json);
            });
        }
    });

    $('#searchlist').on('click','a.list-group-item',function(evt){
        var $this = $(this);
        evt.preventDefault();
        app2.$data.ingredients.push({
            id:$this.data('id'),
            name:$this.data('name'),
            quantity:0,
            preparation:''
        });
    });

});