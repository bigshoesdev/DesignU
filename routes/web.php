<?php
include_once 'web_builder.php';

#Begin DesignU  URL
Route::get('/', ['as' => 'browser', function () {
    return view('browser');
}]);

Route::get('/home', ['as' => 'home', function () {
    return view('index');
}]);

Route::post('/download/image','BasicController@downloadImage' )->name('download.image');

Route::group(['prefix' => 'auth', 'middleware' => 'web', 'namespace' => 'Auth', 'as' => 'auth.'], function () {
    Route::get('login', 'AuthController@getLogin')->name('login');
    Route::post('login', 'AuthController@postLogin')->name('login');

    Route::get('register', 'AuthController@getRegister')->name('register');
    Route::post('register', 'AuthController@postRegister')->name('register');

    Route::get('forgot-password', 'AuthController@getForgotPassword')->name('forgot-password');
    Route::post('forgot-password', 'AuthController@postForgotPassword');
    Route::get('activate/{userId}/{activationCode}', 'AuthController@getActivate')->name('activate');
    Route::get('logout', 'AuthController@getLogout')->name('logout');

    // Socialite Register Routes
    Route::get('/social/redirect/{provider}', ['as' => 'social.redirect', 'uses' => 'SocialController@getSocialRedirect']);
    Route::get('/social/handle/{provider}', ['as' => 'social.handle', 'uses' => 'SocialController@getSocialHandle']);
});

// Begin Half Design
Route::group(['prefix' => 'halfdesign', 'middleware' => 'user', 'namespace' => 'HalfDesign', 'as' => 'halfdesign.'], function () {

    Route::post('/printimage', 'HalfDesignController@printImage')->name('printimage');

    //Print Paper
    Route::get('/printpaper/{customDrawID?}', 'HalfDesignController@printPaperPage')->name('printpaper');
    Route::get('/printpaper/print/{customDrawID?}', 'HalfDesignController@printCustomDrawPage')->name('printpaper.print');
    Route::post('/info/printpaper', 'PrintPaperController@getProductInfoPrintPaper')->name('product.info.printpaper');
    Route::post('/printpaper/printimage', 'PrintPaperController@printCustomDrawImage')->name('printpaper.printimage');

    //Set Info
    Route::get('/setinfo/{id?}', 'HalfDesignController@setInfoPage')->name('setinfo');
    Route::post('setinfo/save', 'SetInfoController@saveInfo')->name('setinfo.saveinfo');
    Route::post('upload/mainimg', 'SetInfoController@uploadMainImg')->name('upload.mainimg');
    Route::post('upload/subimg', 'SetInfoController@uploadSubImg')->name('upload.subimg');

    //Set Auto
    Route::get('/setauto/{id?}', 'HalfDesignController@setAutoPage')->name('setauto');
    Route::post('/info/auto', 'SetAutoController@getProductInfoAuto')->name('product.info.auto');
    Route::post('setauto/save', 'SetAutoController@saveMapping')->name('setauto.savemapping');
    Route::post('upload/designimg', 'SetAutoController@uploadDesignImg')->name('upload.designimg');
    Route::post('upload/patternimg', 'SetAutoController@uploadPatternImg')->name('upload.patternimg');

    //Set Print
    Route::get('/setprint/{id?}', 'HalfDesignController@setPrintPage')->name('setprint');
    Route::post('/info/print', 'SetPrintController@getProductInfoPrint')->name('product.info.print');
    Route::post('setprint/save', 'SetPrintController@savePrinting')->name('setprint.saveprint');

    // CustomDraw
    Route::get('/imageselect', 'HalfDesignController@imageSelectPage')->name('customdraw.imageselect');
    Route::get('/branddesignsource', 'HalfDesignController@brandDesignSourcePage')->name('customdraw.branddesignsource');
    Route::get('/sizeselect', 'HalfDesignController@sizeSelectPage')->name('customdraw.sizeselect');
    Route::post('customdraw/print', 'CustomDrawController@printCustomDraw')->name('customdraw.printdraw');
    Route::post('customdraw/save', 'CustomDrawController@saveCustomDraw')->name('customdraw.savedraw');
    Route::post('customdraw/payinfo', 'CustomDrawController@payInfo')->name('customdraw.payinfo');
    Route::post('/customdraw/pay', 'CustomDrawController@pay')->name('customdraw.pay');
});

Route::group(['prefix' => 'halfdesign', 'middleware' => 'web', 'namespace' => 'HalfDesign', 'as' => 'halfdesign.'], function () {
    Route::get('/', 'HalfDesignController@index')->name('index');
    Route::get('/brandlist', 'HalfDesignController@brandListPage')->name('brandlist');
    Route::get('/productlist', 'HalfDesignController@productListPage')->name('productlist');
    Route::get('/categorylist', 'HalfDesignController@categoryListPage')->name('categorylist');
    Route::get('/brand/{id}', 'HalfDesignController@brandPage')->name('brand');
    Route::get('/category/{id}', 'HalfDesignController@categoryPage')->name('category');
    Route::get('/subimgview/{id?}', 'HalfDesignController@subImgViewPage')->name('subimgview');
    Route::get('/crowdingview/{id?}', 'HalfDesignController@crowdingViewPage')->name('crowdingview');

    Route::get('/customdraw/{productID}/{customDrawID?}', 'HalfDesignController@customDrawPage')->name('customdraw');
    Route::post('/info/customdraw', 'CustomDrawController@getProductInfoCustomDraw')->name('product.info.customdraw');
});
// End Half Design

// Begin MyPage
Route::group(['prefix' => 'mypage', 'middleware' => 'user', 'namespace' => 'MyPage', 'as' => 'mypage.'], function () {
    Route::get('/', 'MyPageController@index')->name('index');
    Route::get('/mywork', 'MyPageController@myWorkPage')->name('mywork');
    Route::get('/sizesetting', 'MyPageController@sizeSettingPage')->name('sizesetting');
    Route::get('/myfolder', 'MyPageController@myFolderPage')->name('myfolder');

    //myorder
    Route::get('/myorder', 'MyPageController@myOrderPage')->name('myorder');
    Route::post('/myorder/exchangereturn', 'MyPageController@exchangeReturn')->name('myorder.exchangereturn');
    Route::post('/myorder/contactinfo', 'MyPageController@contactInfo')->name('myorder.contactinfo');

    //mymoney
    Route::get('/mymoney', 'MyPageController@myMoneyPage')->name('mymoney');

    //setting page
    Route::get('/setting', 'MyPageController@settingPage')->name('setting');
    Route::post('/setting/save', 'SettingController@saveSetting')->name('setting.save');
    Route::post('/setting/uploadpic', 'SettingController@uploadPic')->name('setting.uploadpic');


    Route::get('/address', 'MyPageController@addressPage')->name('address');
    Route::post('/address/add', 'AddressController@addAddress')->name('address.add');
    Route::post('/address/list', 'AddressController@listAddress')->name('address.list');
    Route::post('/address/delete', 'AddressController@deleteAddress')->name('address.delete');
    Route::post('/address/apply', 'AddressController@applyAddress')->name('address.apply');


    //My Folder
    Route::post('/myfolder/addfile', 'MyFolderController@addFile')->name('myfolder.addfile');
    Route::post('/myfolder/createfolder', 'MyFolderController@createFolder')->name('myfolder.createfolder');
    Route::post('/myfolder/changename', 'MyFolderController@changeName')->name('myfolder.changename');
    Route::post('/myfolder/movefile', 'MyFolderController@moveFile')->name('myfolder.movefile');
    Route::post('/myfolder/removefile', 'MyFolderController@removeFile')->name('myfolder.removefile');
    Route::post('/myfolder/downloadfile', 'MyFolderController@downloadFile')->name('myfolder.downloadfile');
    Route::post('/myfolder/info', 'MyFolderController@getFilesInfo')->name('myfolder.info');

    //Size Setting
    Route::post('/sizesetting/info', 'SizeSettingController@getSizeSettingInfo')->name('sizesetting.info');
    Route::post('/sizesetting/delete', 'SizeSettingController@deleteSizeSetting')->name('sizesetting.delete');
    Route::post('/sizesetting/save', 'SizeSettingController@saveSizeSetting')->name('sizesetting.save');
    Route::post('/sizesetting/apply', 'SizeSettingController@applySizeSetting')->name('sizesetting.apply');
});
// End MyPage

// Begin Shopping
Route::group(['prefix' => 'shopmanager', 'middleware' => 'user', 'namespace' => 'ShopManager', 'as' => 'shopmanager.'], function () {
    Route::get('/', 'ShopManageController@index')->name('index');

    //Product Page
    Route::get('/product', 'ShopManageController@productPage')->name('product');
    Route::post('/product/upload/mainimg', 'ProductManageController@uploadMainImg')->name('product.upload.mainimg');
    Route::post('/product/upload/video', 'ProductManageController@uploadVideo')->name('product.upload.video');
    Route::post('/product/upload/subimg', 'ProductManageController@uploadSubImg')->name('product.upload.subimg');
    Route::post('/product/upload/codingfile', 'ProductManageController@uploadCodingFile')->name('product.upload.codingfile');
    Route::post('/product/copyproduct', 'ProductManageController@copyProduct')->name('product.copyproduct');
    Route::post('/product/deleteproduct', 'ProductManageController@deleteProduct')->name('product.deleteproduct');
    Route::post('/product/saveproduct', 'ProductManageController@saveProduct')->name('product.saveproduct');
    Route::post('/product/updateproduct', 'ProductManageController@updateProduct')->name('product.updateproduct');
    Route::post('/product/updateproductstate', 'ProductManageController@updateProductState')->name('product.updateproductstate');
    Route::post('/product/getproducts', 'ProductManageController@getProducts')->name('product.getproducts');
    Route::post('/product/getproduct', 'ProductManageController@getProduct')->name('product.getproduct');
    Route::post('/product/getorderinfo', 'ProductManageController@getOrderInfo')->name('product.getorderinfo');
    Route::post('/product/getorderrequestinfo', 'ProductManageController@getOrderRequestInfo')->name('product.getorderrequestinfo');
    Route::post('/product/getproductiteminfo', 'ProductManageController@getProductItemInfo')->name('product.getproductiteminfo');
    Route::post('/product/getproductitemexchangereturn', 'ProductManageController@getProductItemExchangeReturn')->name('product.getproductitemexchangereturn');
    Route::post('/product/getproductallexchangereturn', 'ProductManageController@getProductAllExchangeReturn')->name('product.getproductallexchangereturn');
    Route::post('/product/getproductallinfo', 'ProductManageController@getProductAllInfo')->name('product.getproductallinfo');
    Route::post('/product/savereturnrequest', 'ProductManageController@saveReturnRequest')->name('product.savereturnrequest');
    Route::post('/product/saveexchangerequest', 'ProductManageController@saveExchangeRequest')->name('product.saveexchangerequest');
    Route::post('/product/sendmail', 'ProductManageController@sendMail')->name('product.sendmail');
    Route::post('/product/downloadnotdeliverylist', 'ProductManageController@downLoadNotDeliveryList')->name('product.downloadnotdeliverylist');

    //Project Page
    Route::get('/project', 'ShopManageController@projectPage')->name('project');
    Route::post('/project/upload/codingfile', 'ProjectManageController@uploadCodingFile')->name('project.upload.codingfile');
    Route::post('/project/getprojects', 'ProjectManageController@getProjects')->name('project.getprojects');
    Route::post('/project/copyproject', 'ProjectManageController@copyProject')->name('project.copyproject');
    Route::post('/project/deleteproject', 'ProjectManageController@deleteProject')->name('project.deleteproject');
    Route::post('/project/updateprojectstate', 'ProjectManageController@updateProjectState')->name('project.updateprojectstate');
    Route::post('/project/getprojectiteminfo', 'ProjectManageController@getProjectItemInfo')->name('project.getprojectiteminfo');
    Route::post('/project/getorderinfo', 'ProjectManageController@getOrderInfo')->name('project.getorderinfo');
    Route::post('/project/getorderrequestinfo', 'ProjectManageController@getOrderRequestInfo')->name('project.getorderrequestinfo');
    Route::post('/project/getprojectitemexchangereturn', 'ProjectManageController@getProjectItemExchangeReturn')->name('project.getprojectitemexchangereturn');
    Route::post('/project/downloadnotdeliverylist', 'ProjectManageController@downLoadNotDeliveryList')->name('project.downloadnotdeliverylist');
    Route::post('/project/savereturnrequest', 'ProjectManageController@saveReturnRequest')->name('project.savereturnrequest');
    Route::post('/project/saveexchangerequest', 'ProjectManageController@saveExchangeRequest')->name('project.saveexchangerequest');

    //Brand Page
    Route::get('/brand', 'ShopManageController@brandPage')->name('brand');
    Route::post('/brand/getinfo', 'BrandManageController@getBrandInfo')->name('brand.getbrandinfo');
    Route::post('/brand/savetip', 'BrandManageController@saveBrandTip')->name('brand.savetip');
    Route::post('/brand/savesns', 'BrandManageController@saveSNS')->name('brand.savesns');
    Route::post('/brand/deletesns', 'BrandManageController@deleteSNS')->name('brand.deletesns');
    Route::post('/brand/savedesignsourceprice', 'BrandManageController@saveDesignSourcePrice')->name('brand.savedesignsourceprice');
    Route::post('/brand/deletedesignsource', 'BrandManageController@deleteDesignSource')->name('brand.deletedesignsource');
    Route::post('/brand/saveshopinfo', 'BrandManageController@saveShopInfo')->name('brand.saveshopinfo');
    Route::post('/brand/upload/mainimg', 'BrandManageController@uploadMainImg')->name('brand.upload.mainimg');
    Route::post('/brand/upload/logoimg', 'BrandManageController@uploadLogoImg')->name('brand.upload.logoimg');
    Route::post('/brand/upload/designsource', 'BrandManageController@uploadDesignSource')->name('brand.upload.designsource');
});

Route::group(['prefix' => 'shopping', 'middleware' => 'web', 'namespace' => 'Shopping', 'as' => 'shopping.'], function () {
    Route::get('/', 'ShoppingController@index')->name('index');
    Route::get('/brandlist', 'ShoppingController@brandListPage')->name('brandlist');
    Route::get('/brand/{id}', 'ShoppingController@brandPage')->name('brand');
    Route::get('/category/{id}', 'ShoppingController@categoryPage')->name('category');
    Route::get('/product/{id}', 'ShoppingController@productPage')->name('product');
    Route::get('/categorylist', 'ShoppingController@categoryListPage')->name('categorylist');
    Route::post('/addcart', 'ShoppingController@addCart')->name('addcart');
    Route::get('/mycart/list', 'ShoppingController@myCartPage')->name('mycart.list');
    Route::get('/mycart/remove/{id}', 'ShoppingController@removeCartItem')->name('mycart.remove');
});

Route::group(['prefix' => 'shopping', 'middleware' => 'user', 'namespace' => 'Shopping', 'as' => 'shopping.'], function () {
    Route::post('/brand/downloaddesignsource','ShoppingController@downloadDesignSource' )->name('downloaddesignsource');
    Route::post('/mycart/payinfo', 'ShoppingController@payInfo')->name('mycart.payinfo');
    Route::post('/mycart/order', 'ShoppingController@order')->name('mycart.order');
});

Route::group(['prefix' => 'payment', 'middleware' => 'user', 'namesapce' => 'Payment', 'as' => 'payment.'], function() {
    Route::post('/paypal/checkout', 'PaypalController@checkOut')->name('paypal.checkout');
});
//
//// End Shopping
//Route::get('/paypal', [
//    'name' => 'PayPal Express Checkout',
//    'as' => 'app.paypal',
//    'uses' => 'PayPalController@form',
//]);
//
//Route::post('/checkout/payment/{order}/paypal', [
//    'name' => 'PayPal Express Checkout',
//    'as' => 'checkout.payment.paypal',
//    'uses' => 'PayPalController@checkout',
//]);
//
//Route::get('/paypal/checkout/{order}/completed', [
//    'name' => 'PayPal Express Checkout',
//    'as' => 'paypal.checkout.completed',
//    'uses' => 'PayPalController@completed',
//]);
//
//Route::get('/paypal/checkout/{order}/cancelled', [
//    'name' => 'PayPal Express Checkout',
//    'as' => 'paypal.checkout.cancelled',
//    'uses' => 'PayPalController@cancelled',
//]);
//
//Route::post('/webhook/paypal/{order?}/{env?}', [
//    'name' => 'PayPal Express IPN',
//    'as' => 'webhook.paypal.ipn',
//    'uses' => 'PayPalController@webhook',
//]);
#End DesignU URL