<!DOCTYPE html>
<html style="background-color: #edf1f5">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.6.1/css/bulma.css">

        <link rel="icon" type="image/png" sizes="16x16" href="public/admin/plugins/images/favicon.png">
        <title>Pixel Admin - Responsive Admin Dashboard Template built with Twitter Bootstrap</title>
        <!-- Bootstrap Core CSS -->
        <link href="public/admin/libs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Menu CSS -->
        <link href="public/admin/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
        <!-- toast CSS -->
        <link href="public/admin/plugins/bower_components/toast-master/css/jquery.toast.css" rel="stylesheet">
        <!-- morris CSS -->
        <link href="public/admin/plugins/bower_components/morrisjs/morris.css" rel="stylesheet">
        <!-- animation CSS -->
        <link href="public/admin/libs/css/animate.css" rel="stylesheet">
        <!-- Custom CSS -->
        <link href="public/admin/libs/css/style.css" rel="stylesheet">
        <!-- color CSS -->
        <link href="public/admin/libs/css/colors/blue-dark.css" id="theme" rel="stylesheet">

        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-route.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <script>
            var app = angular.module('MyApp',['ngRoute', 'ui.bootstrap'])
            const host = "http://localhost/mvc"
            const ALPHABET = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            const generate_id = (ID_LENGTH) => {
                var rtn = '';
                for (var i = 0; i < ID_LENGTH; i++) {
                    rtn += ALPHABET.charAt(Math.floor(Math.random() * ALPHABET.length));
                }
                return rtn.toLowerCase();;
            }

            const isObject = function(obj) {
                return obj === Object(obj);
            }

            app.controller('adminCtrl', function($scope, $http) {
                function getMenu() {
                    $http.get('http://localhost/food_delivery/admin/menu').then((res) => {
                            $scope.menus = res.data
                    })
                }

                function getCategory() {
                    $http.get('http://localhost/food_delivery/admin/category').then((res) => {
                            $scope.categories = res.data
                    })
                }

                function getAllShop() {
                    $http.get('http://localhost/food_delivery/admin/shop').then((res) => {
                        $scope.shops = res.data.map((shop) => {
                            return {
                                id: shop.id,
                                detail: JSON.parse(shop.detail)
                            }
                        })
                    })
                }

                function getTopShop() {
                    $http.get('http://localhost/food_delivery/admin/top_shop').then((res) => {
                        $scope.topShops = res.data
                    })
                }

                $scope.createCategory = () => {
                    if($scope.new_category) {
                        const category_item = {
                            id: generate_id(10),
                            name: $scope.new_category
                        }

                        $http.post('http://localhost/food_delivery/admin/category/create', category_item).then((res) => {
                                $("#categoryDialog").modal('hide')
                                getCategory()
                                $scope.new_category = ""
                        })
                    }
                }

                getMenu()
                getCategory()
                getAllShop()
                getTopShop()

                $scope.addTopShop = (shop_id) => {
                    $scope.top_shops_update.push({
                        id: shop_id
                    })
                }

                $scope.updateTopShop = () => {
                    const data = {
                        top_shop: $scope.top_shops_update
                    }

                    $http.post('http://localhost/food_delivery/admin/top_shop/update', data).then((res) => {
                        $scope.topShops = $scope.top_shops_update
                        $("#suggestShopDialog").modal('hide')
                    })
                }

                $scope.removeTopShop = (index) => {
                    $scope.top_shops_update.splice(index, 1)
                }

                $scope.openTopShopDialog = () => {
                    $scope.top_shops_update = [...$scope.topShops]
                    $("#suggestShopDialog").modal('show')
                }

                $scope.getShopFromID = (id) => {
                    function check_already_choosed(element) {
                        return element.id == id
                    }

                    return $scope.shops.find(check_already_choosed)
                }

                $scope.already_choosed = (shop_id) => {
                    function check_already_choosed(element) {
                        return element.shop_id == shop_id
                    }
                    const shop = $scope.shop_categories.find(check_already_choosed)
                    return !isObject(shop)
                }

                $scope.already_choosed_top_shop = (shop_id) => {
                    function check_already_choosed(element) {
                        return element.id == shop_id
                    }
                    const shop = $scope.top_shops_update.find(check_already_choosed)
                    return !isObject(shop)
                }

                $scope.removeShopCategory = (index) => {
                    $scope.shop_categories.splice(index, 1)
                }

                $scope.addShopCategory = (shop_id) => {
                    $scope.shop_categories.push({
                        id: generate_id(10),
                        shop_id: shop_id,
                        category_id: $scope.update_category_id
                    })
                }

                $scope.removeMenu = (id) => {
                    $("#confirm-delete").modal('show')
                    $scope.remove_id_menu = id
                }

                $scope.confirmRemove = () => {
                    $http.post('http://localhost/food_delivery/admin/menu/delete', {
                        id: $scope.remove_id_menu
                    }).then((res) => {
                            $("#confirm-delete").modal('hide')
                            getMenu()
                    })
                }

                $scope.removeCategory = (id) => {
                    $("#confirm-category-delete").modal('show')
                    $scope.remove_category_id = id
                }

                $scope.confirmCategoryRemove = () => {
                    $http.post('http://localhost/food_delivery/admin/category/delete', {
                        id: $scope.remove_category_id
                    }).then((res) => {
                            $("#confirm-category-delete").modal('hide')
                            getCategory()
                    })
                }


                $scope.showUpdateCategoryDialog = (id, name) =>{
                    $http.get('http://localhost/food_delivery/admin/shop_category/'+ id).then((res) => {
                            $scope.shop_categories = res.data
                            $scope.update_category_id = id
                            $scope.update_category_name = name
                            $("#updateCategoryDialog").modal('show')
                    })
                }

                $scope.updateCategory = () => {
                    const category_item = {
                        id: $scope.update_category_id,
                        name: $scope.update_category_name,
                        shop_category: $scope.shop_categories
                    }

                    $http.post('http://localhost/food_delivery/admin/category/update', category_item).then((res) => {
                            $("#updateCategoryDialog").modal('hide')
                            getCategory()
                    })
                }

                $scope.updateMenu = () => {
                    const menu_item = {
                        id: $scope.updateData.id,
                        name_th: $scope.updateData.name_th,
                        name_en: $scope.updateData.name_en,
                        url: $scope.updateData.url
                    }
                    $http.post('http://localhost/food_delivery/admin/menu/update', menu_item).then((res) => {
                            $("#updateMenuDialog").modal('hide')
                            getMenu()
                    })
                }

                $scope.showUpdateMenuDialog = (index) => {
                    $("#updateMenuDialog").modal('show')
                    $scope.updateData = $scope.menus[index]
                }

                $scope.saveNewMenu = () => {
                    if($scope.new_menu_name_th && $scope.new_menu_name_en && $scope.new_menu_url) {
                        const menu_item = {
                            id: generate_id(10),
                            name_th: $scope.new_menu_name_th,
                            name_en: $scope.new_menu_name_en,
                            url: $scope.new_menu_url
                        }
                        $http.post('http://localhost/food_delivery/admin/menu/create', menu_item).then((res) => {
                                $("#menuDialog").modal('hide')
                                $scope.new_menu_name_th = ""
                                $scope.new_menu_name_en = ""
                                $scope.new_menu_url = ""
                                $scope.menus = [
                                    ...$scope.menus,
                                    menu_item
                                ]
                        })
                    }
                }
            })
            app.controller('shopDetailCtrl', function($scope, $http, $modal, $routeParams, $location) {
                $scope.shop_types = []
                $http.get('http://localhost/food_delivery/admin/shop/'+ $routeParams.id).then((res) => {
                        $scope.detail = JSON.parse(res.data.detail)
                })

                $http.get('http://localhost/food_delivery/admin/shop_menu/'+ $routeParams.id).then((res) => {
                        $scope.shop_menus = res.data
                })

                $http.get('http://localhost/food_delivery/admin/menu').then((res) => {
                        $scope.menus = res.data
                })

                $scope.add_menu = (menu_id) => {
                    $scope.shop_menus.push(menu_id)
                }

                $scope.get_menu_name_from_id = (id) => {
                    function get_menu(element) {
                        return element.id == id
                    }

                    return $scope.menus.find(get_menu)
                }

                $scope.already_choosed = (menu) => {
                    function check_already_choosed(id) {
                        return id == menu.id
                    }
                    const checked = $scope.shop_menus.find(check_already_choosed)
                    return !checked
                }

                $scope.remove_shop_type = (index) => {
                    $scope.shop_menus.splice(index, 1)
                }

                $scope.updateShop = () => {
                    $scope.detail.menu_type = $scope.shop_menus
                    $http.post('http://localhost/food_delivery/admin/shop/update', {
                        id: $routeParams.id,
                        detail: JSON.stringify($scope.detail)
                    }).then((res) => {
                        $http.post('http://localhost/food_delivery/admin/shop_menu/update', {
                            shop_id: $routeParams.id,
                            menu_id: $scope.shop_menus
                        }).then((res) => {
                            $location.path('/shop')
                        })
                    })
                }

                $scope.getCategoryNameByID = (id) => {
                    function findCategoryByID(element) {
                        return element.id == id
                    }

                    const category = $scope.detail.food_type.find(findCategoryByID)
                    return category.name
                }

                $scope.headerImageDialogShow = () => {
                    $scope.header_image_1 = $scope.detail.header_image['0']
                    $scope.header_image_2 = $scope.detail.header_image['1']
                    $scope.header_image_3 = $scope.detail.header_image['2']
                    $("#headerImageDialog").modal('show')
                }

                $scope.saveHeaderImage = () => {
                    $("#headerImageDialog").modal('hide')
                    $scope.detail.header_image['0'] = $scope.header_image_1
                    $scope.detail.header_image['1'] = $scope.header_image_2
                    $scope.detail.header_image['2'] = $scope.header_image_3
                }

                $scope.addFoodType = () => {
                    if($scope.new_food_type) {
                        $scope.detail.food_type.push({
                            id: generate_id(10),
                            name: $scope.new_food_type
                        })
                        $scope.new_food_type = ""
                    }
                }

                $scope.removeCategory = (index) => {
                    $scope.detail.food_type.splice(index, 1)
                }

                $scope.editCategory = (index) => {
                    $scope.update_index = index
                    $scope.update_name_category = $scope.detail.food_type[index].name
                    $("#categoryDialog").modal('show')
                }

                $scope.updateCategoryName = () => {
                    $scope.detail.food_type[$scope.update_index].name = $scope.update_name_category
                    $("#categoryDialog").modal('hide')
                }

                $scope.addFood = () => {
                    if($scope.new_food_url && $scope.new_food_name && $scope.new_food_price && $scope.new_food_category) {
                        $scope.detail.product_list.push({
                            id: generate_id(10),
                            url_image: $scope.new_food_url,
                            name: $scope.new_food_name,
                            price: $scope.new_food_price,
                            category: $scope.new_food_category
                        })

                        $scope.new_food_url = ""
                        $scope.new_food_name = ""
                        $scope.new_food_price = ""
                        $scope.new_food_category = ""
                    }

                }

                $scope.removeFood = (index) => {
                    $scope.detail.product_list.splice(index, 1)
                }

                $scope.showUpdateProductDialog = (index) => {
                    $scope.update_food_url = $scope.detail.product_list[index].url_image
                    $scope.update_food_name = $scope.detail.product_list[index].name
                    $scope.update_food_price = $scope.detail.product_list[index].price
                    $scope.update_food_category = $scope.detail.product_list[index].category
                    $scope.update_index = index
                    $("#productDialog").modal('show')
                }

                $scope.updateProduct = () => {
                    $("#productDialog").modal('hide')
                    $scope.detail.product_list[$scope.update_index].url_image = $scope.update_food_url
                    $scope.detail.product_list[$scope.update_index].name = $scope.update_food_name
                    $scope.detail.product_list[$scope.update_index].price = $scope.update_food_price
                    $scope.detail.product_list[$scope.update_index].category = $scope.update_food_category
                }

            })
            app.controller('orderCtrl', function($scope, $http) {

            })
            app.controller('userCtrl', function($scope, $http, $location) {
                // $http.get(host + '/api/user').then((res) => {
                //     $scope.users = res.data
                // })
                //
                // $http.get(host + '/api/role').then((res) => {
                //     $scope.roles = res.data
                // })
                //
                // $scope.create_user = () => {
                //     if($scope.user && $scope.user.name && $scope.user.username && $scope.user.password && $scope.user.role && $scope.user.order_address) {
                //         if($scope.user.password.length >= 6) {
                //             $scope.user.user_id = generate_id(10)
                //             $http.post(host + '/api/user/create', $scope.user).then((res) => {
                //                 $location.path('/user')
                //             })
                //         } else {
                //             $scope.error_message = "password ควรมีความยาวเกิน 6 ตัวอักษร !! "
                //         }
                //     } else {
                //         $scope.error_message = "กรุณากรอกข้อมูลที่จำเป็นให้ครับทุกช่อง !! "
                //     }
                // }
                //
                // $scope.user_profile = (user_id) => {
                //     $location.path('/user/'+ user_id)
                // }
            })
            app.controller('userProfileCtrl', function($scope, $http, $location, $routeParams) {
                // $http.get(host + '/api/user/' + $routeParams.user_id).then((res) => {
                //     $scope.user = res.data
                // })
                //
                // $http.get(host + '/api/role').then((res) => {
                //     $scope.roles = res.data
                // })
                //
                // $scope.create_user = () => {
                //     if($scope.user && $scope.user.name && $scope.user.username && $scope.user.password && $scope.user.role && $scope.user.order_address) {
                //         if($scope.user.password.length >= 6) {
                //             $http.post(host + '/api/user/update', $scope.user).then((res) => {
                //                 $location.path('/user')
                //             })
                //         } else {
                //             $scope.error_message = "password ควรมีความยาวเกิน 6 ตัวอักษร !! "
                //         }
                //     } else {
                //         $scope.error_message = "กรุณากรอกข้อมูลที่จำเป็นให้ครับทุกช่อง !! "
                //     }
                // }
            })
            app.controller('shopCtrl', function($scope, $http, $location, $routeParams) {
                $scope.createShopDialogOpen = () => {
                    $("#createShopDialog").modal('show')
                }

                $scope.shop_detail = (id) => {
                    $location.path('/shop/' + id);
                }

                $http.get('http://localhost/food_delivery/admin/shop').then((res) => {
                        $scope.shops = []
                        res.data.forEach(function(shop) {
                            $scope.shops.push({
                                id: shop.id,
                                content: JSON.parse(shop.detail)
                            })
                        })
                })

                const detail = {
                    title: '',
                    detail: '',
                    phone: '',
                    email: '',
                    url_img_profile: '',
                    lat_lng: '',
                    header_image: {
                        '0': '',
                        '1': '',
                        '2': ''
                    },
                    food_type: [
                    ],
                    product_list: [
                    ]
                }

                $scope.createShop = () => {
                    const id  = generate_id(10)
                    detail.title = $scope.new_shop
                    if($scope.new_shop) {
                        const shop_prototype = {
                            id: id,
                            detail: JSON.stringify(detail)
                        }

                        $http.post('http://localhost/food_delivery/admin/shop/create', shop_prototype).then((res) => {
                            $("#createShopDialog").modal('hide')
                            $location.path('/shop/' + id);
                        })
                    }
                }
            })
            app.component('navbar', {
                templateUrl: 'public/admin/component/navbar/index.html',
                controller: function() {
                }
            })
            app.component('sidebar', {
                templateUrl: 'public/admin/component/sidebar/index.html',
                controller: function() {
                }
            });
            app.config(function($routeProvider) {
                $routeProvider
                .when("/", {
                    templateUrl: 'public/admin/content/admin/index.html',
                    controller: 'adminCtrl',
                })
                .when("/shop/:id", {
                    templateUrl: 'public/admin/content/shop_detail/index.html',
                    controller: 'shopDetailCtrl',
                })
                .when("/shop", {
                    templateUrl: "public/admin/content/shop/index.html",
                    controller: 'shopCtrl'
                })
                .when("/order", {
                    templateUrl: 'public/admin/content/order/index.html',
                    controller: 'orderCtrl',
                })
                .when("/user", {
                    templateUrl: 'public/admin/content/user/index.html',
                    controller: 'userCtrl',
                })
                .when("/user/add", {
                    templateUrl: 'public/admin/content/user/user_profile.html',
                    controller: 'userCtrl',
                })
                .when("/user/:user_id", {
                    templateUrl: 'public/admin/content/user/user_profile.html',
                    controller: 'userProfileCtrl',
                })
            })
        </script>
    </head>
        <body ng-app="MyApp">
            <div id="wrapper">
                <sidebar></sidebar>
                <navbar></navbar>
                <!-- <div class="header clearfix" ng-controller="navbar"> -->
                <div ng-view></div>
            </div>
        </div>

        <script src="public/admin/plugins/bower_components/jquery/dist/jquery.min.js"></script>
        <!-- Bootstrap Core JavaScript -->
        <script src="public/admin/libs/bootstrap/dist/js/bootstrap.min.js"></script>
        <!-- Menu Plugin JavaScript -->
        <script src="public/admin/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js"></script>
        <!--slimscroll JavaScript -->
        <script src="public/admin/libs/js/jquery.slimscroll.js"></script>
        <!--Wave Effects -->
        <script src="public/admin/libs/js/waves.js"></script>
        <!--Counter js -->
        <script src="public/admin/plugins/bower_components/waypoints/lib/jquery.waypoints.js"></script>
        <script src="public/admin/plugins/bower_components/counterup/jquery.counterup.min.js"></script>
        <!--Morris JavaScript -->
        <script src="public/admin/plugins/bower_components/raphael/raphael-min.js"></script>
        <script src="public/admin/plugins/bower_components/morrisjs/morris.js"></script>
        <!-- Custom Theme JavaScript -->
        <script src="public/admin/libs/js/custom.min.js"></script>
        <script src="public/admin/libs/js/dashboard1.js"></script>
        <script src="public/admin/plugins/bower_components/toast-master/js/jquery.toast.js"></script>
        <script src="http://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.6.0.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


        <script type="text/javascript">
        $(document).ready(function() {
            $.toast({
                heading: 'Welcome to Pixel admin',
                text: 'Use the predefined ones, or specify a custom position object.',
                position: 'top-right',
                loaderBg: '#ff6849',
                icon: 'info',
                hideAfter: 3500,
                stack: 6
            })
        });
        </script>
    </body>
</html>
