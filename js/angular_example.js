angular.module('Hotels', ['ngSanitize']).controller('hoteles', function($scope) {
    $scope.names = [
        {
        	name:'Hotel Emperador',
        	src:'http://www.emperadorhotel.com/d/emperadormadrid/media/__thumbs_1600_714_crop/Piscina_Hotel_Emperador_Madrid.jpg?1457524338',
        	stars:'<i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i>',
        	details:'<i class="fa fa-bed" aria-hidden="true"></i> solo habitación',
        	icons:'<i class="fa fa-wifi" aria-hidden="true"></i> <i class="fa fa-thumbs-up" aria-hidden="true"></i> <i class="fa fa-ticket" aria-hidden="true"></i> <i class="fa fa-television" aria-hidden="true"></i> <i class="fa fa-umbrella" aria-hidden="true"></i> <i class="fa fa-wheelchair" aria-hidden="true"></i> <i class="fa fa-bed" aria-hidden="true"></i>', //aca irían iconos, pero no voy a hacer la f(x) para adaptar esto... no time
        	price:1596
        },
        {
        	name:'Hotel Nuevo Boston',
        	src:'http://en.hotelnuevoboston.com/uploads/cms_apps/imagenes/atril-eventos-hotel-nuevo-boston.jpg',
        	stars:'<i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i>',
        	details:'<i class="fa fa-bed" aria-hidden="true"></i> solo habitación',
        	icons:'<i class="fa fa-wifi" aria-hidden="true"></i> <i class="fa fa-thumbs-up" aria-hidden="true"></i> <i class="fa fa-bed" aria-hidden="true"></i>',
        	price:10500
        },
        {
        	name:'Petit Palace San Bernardo',
        	src:'http://photos0.hotelsearch.com/0030/5764/petit-palace-san-bernardo-madrid_big.jpg',
        	stars:'<i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i>',
        	details:'<i class="fa fa-bed" aria-hidden="true"></i> solo habitación',
        	icons:'<i class="fa fa-wifi" aria-hidden="true"></i> <i class="fa fa-thumbs-up" aria-hidden="true"></i> <i class="fa fa-television" aria-hidden="true"></i> <i class="fa fa-umbrella" aria-hidden="true"></i> <i class="fa fa-wheelchair" aria-hidden="true"></i> <i class="fa fa-bed" aria-hidden="true"></i>',
        	price:2145
        },
        {
        	name:'Hotel Nuevo Boston',
        	src:'http://en.hotelnuevoboston.com/uploads/cms_apps/imagenes/atril-eventos-hotel-nuevo-boston.jpg',
        	stars:'<i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i>',
        	details:'<i class="fa fa-bed" aria-hidden="true"></i> solo habitación',
        	icons:'<i class="fa fa-wifi" aria-hidden="true"></i> <i class="fa fa-thumbs-up" aria-hidden="true"></i> <i class="fa fa-bed" aria-hidden="true"></i>',
        	price:861
        }
    ];
    
    //some f(x) shit for show some skills [??]
    $scope.orderByMe = function(x) {
    	$scope.myOrderBy = x;
  	}
    
    // notes 
    /*
     * for //price//, here in the array is static, the matter is, for make int really float, need to be filtered before
     * i've placed HTML entities inside, and binding in response just for speedup test, i can't write the API in nodeJS because we know it takes less than 4h, if we can wrote the API well..
     * And, for bad casualtities, i need to work to live: so, i can't develop the API consuming angular, so i'm using angular consuming a simple object to make test faster
     */
    
    //this method is insecure, but... it's just a fuckin' test. For better skills, payment needed :(
}); 