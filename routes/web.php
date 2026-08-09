<?php
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VerificationController;
use App\Http\Livewire\Account\Favorite\Favorite;
use App\Http\Livewire\Account\Orders\Orders;
use App\Http\Livewire\Account\Password\Password;
use App\Http\Livewire\Account\Refunds\DetailsComponent as RefundDetailsComponent;
use App\Http\Livewire\Account\Refunds\Refunds;
use App\Http\Livewire\Account\Refunds\RequestComponent as RefundRequestComponent;
use App\Http\Livewire\Account\Reviews\Reviews;
use App\Http\Livewire\Account\Settings\Settings;
use App\Http\Livewire\Auth\CompleteRegister;
use App\Http\Livewire\BecomeSeller;
use App\Http\Livewire\Seller\DashboardComponent as SellerDashboardComponent;
use App\Http\Livewire\Seller\Orders\DetailsComponent as SellerOrderDetailsComponent;
use App\Http\Livewire\Seller\Orders\DeliverComponent as SellerOrderDeliverComponent;
use App\Http\Livewire\Account\Orders\FilesComponent as AccountOrderFilesComponent;
use App\Http\Controllers\Uploads\Delivered\DeliveredController;
use App\Http\Livewire\Cart\CartComponent;
use App\Http\Livewire\Categories\AllGigsComponent;
use App\Http\Livewire\Categories\GigsComponent as CategoriesGigsComponent;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Livewire\Categories\SearchComponent;
use App\Http\Livewire\Messages\MessagesComponent;
use App\Http\Livewire\Checkout\CheckoutComponent;
use App\Http\Livewire\PageComponent;
use App\Http\Livewire\Profile\EditProfile;
use App\Http\Livewire\ResetComponent;
use App\Http\Livewire\Services\ServicesComponent;
use App\Http\Livewire\UpdateComponent;
use App\Http\Livewire\VerifyNews;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// home
Route::get('/',  App\Http\Livewire\HomeComponent::class)->name('home');


Route::namespace('App\Http\Livewire')->middleware('auth')->group(function() {

    // Logout
    Route::get('/logout', LogoutComponent::class);

    // messages 
    Route::namespace('Messages')->prefix('messages')->group(function() {

        // Index
        Route::get('/{conversationId?}', MessagesComponent::class)->name('messages');

        // New
        Route::get('new/{username}', NewComponent::class);


    });
    // account
    Route::namespace('Account')->prefix('account')->group(function() {

        // Index/settings
        Route::get('/settings', Settings::class);
        // Password
        Route::get('/password', Password::class);
        // Favorite
        Route::get('/favorite', Favorite::class);
        // my orders
        Route::get('/orders', Orders::class);
        Route::get('/orders/files', AccountOrderFilesComponent::class);
        // my reviews
        Route::get('/reviews', Reviews::class);
        // refunds
        Route::get('/refunds', Refunds::class);
        Route::get('/refunds/request/{id}', RefundRequestComponent::class);
        Route::get('/refunds/details/{id}', RefundDetailsComponent::class);


    });

    // edit profile
    Route::get('/edit/profile', EditProfile::class)->name("editProfile");

    // become a seller
    Route::get('/become-seller', BecomeSeller::class);
});

// seller
Route::namespace('App\Http\Livewire\Seller')->middleware(['auth', 'seller'])->prefix('seller')->group(function() {

    // dashboard
    Route::get('/home', SellerDashboardComponent::class);

    // orders
    Route::get('orders/details/{id}', SellerOrderDetailsComponent::class);
    Route::get('orders/deliver/{id}', SellerOrderDeliverComponent::class);

});

// reset
Route::get('/reset',  ResetComponent::class);


// update password
Route::get('auth/password/update',UpdateComponent::class )->middleware('time');

// reset
Route::get('/expired', function () {
    return view('error.expired');
});

Route::group(['middleware' => ['auth']], function() {

    // verification email
    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {

        $request->fulfill();

        return redirect('/afterregister')->with('success','Email has been verified.');

    })->name('verification.verify')->middleware(['signed']);

    // resend verification email
    Route::get('/email/resend', [VerificationController::class,"resend"])->name('verification.resend');

    // complete registration
    Route::get('/afterregister', CompleteRegister::class)->name("afterRegister")->middleware('completed');

    // user profile
    Route::get('/profile', [ProfileController::class,"index"])->name("profile")->middleware(['notCompleted']);

    // download delivered work file (buyer or seller of the order item)
    Route::get('orders/delivered/download/{orderId}/{itemId}/{workId}/{fileId}', [DeliveredController::class, 'download']);


});

// search
Route::get('/search', [GigsController::class,"search"]);


Route::namespace('App\Http\Livewire')->group(function() {
    
        // Categories
    Route::namespace('Categories')->prefix('categories')->group(function() {

        // all categories + category
        Route::get('{parent}',CategoriesGigsComponent::class);

        // Subcategory
        Route::get('{parent}/{subcategory}', SubcategoryComponent::class);


    });
    Route::get('category/all',AllGigsComponent::class);


    Route::namespace('Categories')->group(function() {

        // search for gigs with a key
        Route::get('/search',SearchComponent::class);

    });
     // Service
    Route::namespace('Service')->prefix('service')->group(function() {

        // Slug
        Route::get('{slug}', ServicesComponent::class)->name('service');

    });

    // Page
    Route::prefix('page')->group(function() {

        // Slug
        Route::get('{slug}', PageComponent::class)->name('page');

    });

    // // verify newsletter
        Route::get('newsletter/verify',VerifyNews::class);

    // Cart
    Route::namespace('Cart')->prefix('cart')->group(function() {

        Route::get('/', CartComponent::class);

    });

    // Checkout
    Route::namespace('Checkout')->middleware('auth')->prefix('checkout')->group(function() {

        Route::get('/', CheckoutComponent::class)->name('checkout');
        
        


    });
});

// page contact
Route::get('/contact',[ContactController::class,'index'])->name('contact');

// send message of contact
Route::get('/send',[ContactController::class,'send'])->name('send');

// public profil
Route::get('/profile/{username}', [ProfileController::class,"profile"])->name("profileVisitor");


