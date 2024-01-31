<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\Bid;
use App\Models\History;
use App\Models\PayOrder;
use App\Models\RefCount;
use App\Models\ReferralsSum;
use App\Models\UsersFavorite;
use App\Helpers\CheckListHelper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\ProfileRequest;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    /**
     * Create a new controller instance
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        //$this->middleware('activated');
        //$currentLayout = view()->current()->getName();
        //echo($currentLayout);

    }

    /**
     * Show the application dashboard
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function profile()
    {
        $user = \Auth::user();
        $bids = Bid::where('user_id', $user->id)->orderBy('id', 'desc')->take(10)->get();
        $pay = PayOrder::where('user_id', $user->id)//->where('success', 1)
        ->whereNull('auction_id')->where('add_bid', 1)->get();

        $sumBid = 0;
        foreach ($pay as $bidAdd) {
            if ($bidAdd->shop) {
                $sumBid = $sumBid + $bidAdd->shop->count;
            }
        }
        $bidsArr = [];
        foreach ($bids as $bid) {
            if ($this->isLeader($bid->auction_id, $user->id, $bid->id)) {
                $bid->is_leader = true;
            }
            if ($this->isLast($bid->auction_id, $user->id, $bid->id)) {
                $bid->is_last = true;
            }
            array_push($bidsArr, $bid);
        }
        $refTable = RefCount::where('user_id', $user->id)->orderBy('first_sum', 'desc')
            ->take(10)->get();
        $refRegister = RefCount::where('user_id', $user->id)->count();
        $refSum = RefCount::where('user_id', $user->id)->sum('first_sum');

        $auctionList = [
            'active' => Auction::listActive(),
            'won' => Auction::listDisabled(),
        ];
        $histories = History::query()->where('user_id', $user->id)->take(20)->get();
        return view(
            'profile.profile',
            [
                'title' => 'Профиль',
                'user' => $user,
                'bids' => $bids,
                'pay' => $sumBid,
                'referrals' => $refTable,
                'histories' => $histories,
                'refSum' => $refSum,
                'refRegister' => $refRegister,
                'auctionList' => $auctionList,
            ]
        );
    }

    /**
     * Страница настройки
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    //$currentLayout = View::getLayout();

    public function settings(Request $request)
    {
        $user = \Auth::user();

        if ($request->isMethod('post')) {

            $request->validate([
                'telegram' => 'required',
                'phone' => 'required',
                'mailing' => 'required',
                'firstname' => 'required',
                'patronymic' => 'required',
                'lastname' => 'required',
                'photo' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg',

            ]);

            // Handle photo upload
            if ($request->file('photo')) {
                $photoPath = $request->file('photo')->store('photos', 'public');
                $user->photo = $photoPath;
            }


            $user->delivery_region = $request->input('delivery_region');
            $user->delivery_city = $request->input('delivery_city');
            $user->delivery_street = $request->input('delivery_street');
            $user->delivery_house = $request->input('delivery_house');
            $user->telegram = $request->input('telegram');
            $user->instagram = $request->input('instagram');
            $user->phone = $request->input('phone');
            $user->firstname = $request->input('firstname');
            $user->patronymic = $request->input('patronymic');
            $user->lastname = $request->input('lastname');
            $user->email = $request->input('email');

            $user->news_notification = $request->has('news_notification');
            $user->mailing = $request->has('mailing');

            $user->save();

            return redirect()->route('settings');
        }

        return view(
            'profile.settings',
            [
                'title' => 'Настройки',
                'user' => $user,
            ]
        );
    }

    /**
     * Партнерская программа
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function referral()
    {
        $user = \Auth::user();
        CheckListHelper::instance()->mark(11);

        return view(
            'profile.referral',
            [
                'title' => 'Партнерская программа',
                'user' => $user,
            ]
        );
    }

    /**
     * Токены
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function tokens()
    {
        $tokens = [
            [
                'value' => 1000,
                'price' => 1500,
                'image' => '/img/main/goblet.png',
            ],
            [
                'value' => 2500,
                'price' => 1999,
                'image' => '/img/main/goblet.png',
            ],
            [
                'value' => 7500,
                'price' => 5499,
                'image' => '/img/main/goblet.png',
            ],
            [
                'value' => 15000,
                'price' => 9999,
                'image' => '/img/main/goblet.png',
            ],
            [
                'value' => 25000,
                'price' => 14999,
                'image' => '/img/main/goblet.png',
            ],
            [
                'value' => 50000,
                'price' => 20999,
                'image' => '/img/main/goblet.png',
            ],
            [
                'value' => 75000,
                'price' => 33999,
                'image' => '/img/main/goblet.png',
            ],
            [
                'value' => 100000,
                'price' => 49999,
                'image' => '/img/main/goblet.png',
            ],
        ];

        return view(
            'profile.tokens',
            [
                'title' => 'Тарифы покупки FLAMES',
                'tokens' => $tokens,
            ]
        );
    }

    public function isLeader($auctionId, $userId, $bidId)   //todo данная фукнция правктически не используется, вместо нее есть уже метод в модели аукционов
    {
        $bid = Bid::where('auction_id', $auctionId)->orderBy('id', 'desc')->first();
        if ($bid) {
            $auction = Auction::find($auctionId);
            if ($auction && $bid['user_id'] == $userId && $auction->status_id == 3
                && $bid['id'] == $bidId
            ) {
                return true;
            }
        }
        return false;
    }

    public function isLast($auctionId, $userId, $bidId)
    {
        $bid = Bid::where('auction_id', $auctionId)->orderBy('id', 'desc')->first();
        if ($bid) {
            $auction = Auction::find($auctionId);
            if ($auction && $bid['user_id'] == $userId && $auction->status_id !== 3
                && $bid['id'] == $bidId
            ) {
                return true;
            }
        }
        return false;
    }

    public function passwordChange(Request $request)
    {
        $data = $request->all();
        $responseData = [];
        if ($data['password']) {
            if ($data['password'] !== $data['password_repeat']) {
                $responseData['status'] = 'error';
                $responseData['message']
                    = 'Проверьте новый пароль, он не совпадает с введенным ниже';
            } else {
                if (strlen($data['password']) < 8) {
                    $responseData['status'] = 'error';
                    $responseData['message'] = 'Пароль должен быть минимум 8 символов';
                } else {
                    $user = \Auth::user();
                    if ($user) {
                        if (\Auth::attempt(
                            ['email' => $user->email, 'password' => $data['old_password']]
                        )
                        ) {
                            $user->password = \Hash::make($data['password']);
                            $user->save();
                            $responseData['status'] = 'success';
                            $responseData['redirectUrl'] = route('change-password-finish');
                        } else {
                            $responseData['status'] = 'error';
                            $responseData['message'] = 'Старый пароль не верный';
                        }
                    }
                }
            }
        }
        return $responseData;
    }

    /**
     * Метод обновления аватара
     *
     * @param Request $request
     *
     * @return false|string
     */
    public function avatarChange(Request $request)
    {
        $result = [
            'error' => '',
            'filePath' => '',
        ];

        $user = \Auth::user();


        if ($user) {
            $request->validate(
                [
                    'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                ]
            );

            // Удалим старый файл аватара, если он есть
            if (($user->photo !== null) && !$this->deleteFile($user->photo)) {
                $result['error'] = 'Не удалось удалить файл' . PHP_EOL;
            }

            $avatarFileName = time() . '.' . $request->avatar->extension();

            $request->avatar->move(public_path(env('AVATAR_PATH')), $avatarFileName);

            $user->photo = $avatarFileName;

            if ($user->save()) {
                $result['filePath'] = asset(env('AVATAR_PATH')) . '/' . $avatarFileName;
            } else {
                $result['error'] .= 'Не удалось сохранить модель пользователя';
            }
        }

        return json_encode($result);
    }

    /**
     * Метод удаления аватара
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function avatarDelete()
    {
        $result = [];
        $user = \Auth::user();
        if ($user && $user->photo != null) {
            if ($this->deleteFile($user->photo)) {
                $user->photo = null;
                if ($user->save()) {
                    $result['success'] = 'You have successfully delete avatar.';
                } else {
                    $result['error'] = 'Не удалось сохранить модель пользователя';
                }
            } else {
                $result['error'] = 'Не удалось удалить файл';
            }
        }

        return back()
            ->with(key($result), current($result));
    }

    public function addToFavorite($id)
    {
        $user = \Auth::user();
        $addToFavorite = UsersFavorite::where('user_id', $user->id)->where(
            'auction_id', $id
        )->first();
        if ($addToFavorite) {
            $addToFavorite->delete();
            return 'delete';
        } else {
            $addToFavorite = new UsersFavorite();
            $addToFavorite->user_id = $user->id;
            $addToFavorite->auction_id = $id;
            $addToFavorite->save();
            return 'add';
        }
    }

    /**
     * Метод удаления файла аватара пользователя
     *
     * @param $fileName string Имя файла аватара пользователя
     *
     * @return bool
     */
    private function deleteFile($fileName)
    {
        $filePath = "storage/" . $fileName;


        if (file_exists($filePath)) {
            if (unlink($filePath)) {
                return true;
            }
        }
        return false;
    }

    public function getLastWeekEarning(): \Illuminate\Http\JsonResponse
    {
        $items = ReferralsSum::query()
            ->where('user_id', auth()->user()->id)
            ->whereDate('created_at', '>=', Carbon::now()->subWeek())
            ->get();

        $groupedItems = $items->groupBy(function ($date) {
            // Возвращаем день недели в формате ПН, ВТ, СР и т.д.
            return Carbon::parse($date->created_at)->isoFormat('d');
        });

        $returns = [
        ];
        foreach ($groupedItems as $day => $group) {
            $sum = $group->sum('sum'); // Предполагаем, что сумма находится в поле 'sum'
            $returns[] = [$day, $sum];
        }

        return response()->json($returns);
    }

    public function getLastMonthEarning(): \Illuminate\Http\JsonResponse
    {
        $items = ReferralsSum::query()
            ->where('user_id', auth()->user()->id)
            ->whereDate('created_at', '>=', Carbon::now()->subMonth())
            ->get();

        $groupedItems = $items->groupBy(function ($date) {
            // Возвращаем день недели в формате ПН, ВТ, СР и т.д.
            return Carbon::parse($date->created_at)->isoFormat('d');
        });

        $returns = [
        ];
        foreach ($groupedItems as $day => $group) {
            $sum = $group->sum('sum'); // Предполагаем, что сумма находится в поле 'sum'
            $returns[] = [$day, $sum];
        }

        return response()->json($returns);
    }

    public function sendVerifyEmail()
    {
        $user = auth()->user();

        $confirmed = $user->confirmed;

        if (isset($confirmed) && $confirmed == "0") {
            // If the user has not had an activation token set
            $confirmation_code = $user->confirmation_code;
            if (empty($confirmation_code) || $confirmation_code == "0") {
                // generate a confirmation code
                $key = env('APP_KEY');
                $confirmation_code = hash_hmac('sha256', Str::random(40), $key);
                $user->confirmation_code = $confirmation_code;
                $user->save();
            }
            $actionUrl = route('activate', ['token' => $confirmation_code]);

            Mail::send(['emails.activate', 'emails.activate_text'], ['actionUrl' => $actionUrl, 'name' => $user->firstname], function ($message) use ($user) {
                $message->to($user->getEmailForPasswordReset(), $user->firstname)
                    ->subject('Активация аккаунта');
            });

            $user->is_send_conf = true;
            $user->save();
            return response()->json(['status' => true]);
        }

        return response()->json(['status' => false, 'message' => "Ваш аккаунт уже активирован"]);


    }
}
