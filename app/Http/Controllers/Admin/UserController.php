<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Library\Notification\Email;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    /**
     * View list of specific User type
     *
     * @param string $userType
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function index(Request $request)
    {

        $query = User::where('id', '!=', 1);

        if ($request->name_key) {
            $query = $query->where(function ($query) use ($request) {
                $query->where('name', 'like', "%{$request->name_key}%")
                    ->orWhere('email', 'like', "%{$request->name_key}%");
            });
        }

        if ($request->download) {
            $users = $query->orderBy('name', 'ASC')->get();

        } else {
            $users = $query->orderBy('name', 'ASC')->paginate(15);
        }

        if ($request->download) {
            $this->_downloadUsers($users);
        }

        $request->flash();

        return view('admin.user.index', [
            'users' => $users,
        ]);
    }

    private function _downloadUsers($users)
    {
        // dd($users->toArray());
        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename=users.csv");
        $output = fopen('php://output', 'w');

        fputcsv($output, [
            'Name',
            'Email',
            'Username',
            'Mobile',
        ]);

        foreach ($users as $user) {
            $row = [
                $user->name,
                $user->email,
                $user->username,
                $user->mobile,
            ];
            fputcsv($output, $row);
        }
        fclose($output);

        exit();
    }

    /**
     * View user create form page
     *
     * @param string $userType
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function create(Request $request)
    {

        if ($request->session()->has('bulk')) {
            $bulk = intval($request->session()->get('bulk'));
            $request->session()->forget('bulk');
        } else {
            $bulk = false;
        }

        return view('admin.user.create', [
            'bulk' => $bulk,
        ]);
    }

    /**
     * Add a new User with appropriate requests
     *
     * @param Request $request
     * @param string $userType
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {

        if ($request->bulk) {
            return $this->_addUserInBulk($request);
        } else {
            return $this->_addSingleUser($request);
        }
    }

    private function _addUserInBulk(Request $request)
    {

        $errorCount = $addCount = 0;

        $request->session()->put('bulk', 1);

        if ($request->hasFile('user_bulk')) {
            $this->validate($request, [
                'user_bulk' => 'required|mimes:xls,xlsx,csv',
            ]);

            $fileMime = $request->file('user_bulk')->getMimeType();

            $path = $request->file('user_bulk')->getRealPath();

            $fileData = Excel::toArray('', $path, null, excel_file_type($fileMime))[0];

            if (count($fileData) > 0) {

                $arrRow = $arrCols = [];

                foreach ($fileData as $key => $row) {
                    if ($key <= 0) {
                        $arrCols = array_map(function ($s) {
                            return trim(strtolower($s));
                        }, $row);
                        if (!in_array('email', $arrCols)) {
                            session()->flash('status', 'Data import failed! Column keys not found!');
                            break;
                        }
                        continue;
                    }

                    $arrRow = array_combine($arrCols, $row);

                    $userData = [
                        'fullname' => $arrRow['fullname'],
                        'email' => $arrRow['email'],
                        'password' => isset($arrRow['password']) && !empty($arrRow['password']) ? $arrRow['password'] : 'Temp1123',
                        'username' => isset($arrRow['username']) ? $arrRow['username'] : '',
                        'mobile' => $arrRow['mobile'],
                    ];

                    if (empty($userData['fullname']) || empty($userData['email']) || empty($userData['mobile'])) {
                        $errorCount++;
                        continue;
                    }

                    if (User::where('email', $userData['email'])->exists()) {
                        $errorCount++;
                        continue;
                    }
                    if (!preg_match('/^(?:\+88|88)?(01[3-9]\d{8})/', $userData['mobile']) && strlen($userData['mobile']) == 10) {
                        $userData['mobile'] = "0{$userData['mobile']}";
                    }

                    $result = User::addUser($userData);

                    if (!$result['success']) {
                        $errorCount++;
                    } else {
                        // $tokenData = \App\Actions\UserActivation::init($result['user']);
                        // $result = Email::getInstance()->initConfig([
                        //     'receiver' => $userData['email'],
                        //     'type' => 'new-user',
                        //     'data' => [
                        //         'fullname' => $userData['firstname'] . ' ' . $userData['lastname'],
                        //         'url' => url('/user/activate') . "?data=$tokenData",
                        //         'username' => $userData['email'],
                        //         'password' => $userData['password'],
                        //     ],
                        // ])->send();

                        $addCount++;
                    }
                }
            }

        } else {
            $userData = [];
            if (count($request->users) > 0) {
                foreach ($request->users as $user) {
                    $userData = [
                        'fullname' => $user['fullname'],
                        'email' => $user['email'],
                        'password' => 'Temp1123',
                        'username' => $user['username'],
                        'mobile' => $user['mobile'],
                    ];
                    $validator = Validator::make($userData, [
                        "firstname" => "required|string|max:100",
                        'email' => 'required|email|unique:users,email',
                        'username' => 'required|string|max:100',
                        'mobile' => 'required|unique:users,mobile',
                    ]);

                    if ($validator->fails()) {
                        $errorCount++;
                        continue;
                    }

                    $result = User::addUser($userData);

                    if (!$result['success']) {
                        $errorCount++;
                    } else {
                        $addCount++;
                    }
                }
            }
        }

        if ($errorCount > 0) {
            session()->flash('status', 'Error! ' . $errorCount . ' users failed to insert!');
        }
        if ($addCount > 0) {
            session()->flash('success', 'Success! ' . $addCount . ' users has been added!');
        }
        return back();
    }

    private function _addSingleUser(Request $request)
    {

        $this->_validateRequests($request);

        $userData = [
            'fullname' => $request->fullname,
            'email' => $request->email,
            'password' => $request->password,
            'username' => $request->username,
            'mobile' => $request->mobile,
        ];

        $result = User::addUser($userData);

        if ($result['success']) {
            // $tokenData = \App\Actions\UserActivation::init($result['user']);
            // $result = Email::getInstance()->initConfig([
            //     'receiver' => $userData['email'],
            //     'type' => 'new-user',
            //     'data' => [
            //         'fullname' => $userData['firstname'] . ' ' . $userData['lastname'],
            //         'url' => url('/user/activate') . "?data=$tokenData",
            //         'username' => $userData['email'],
            //         'password' => $userData['password'],
            //     ],
            // ])->send();

            // if ($result === true) {
            //     return back()->with('success', 'Request has been sent! Please check your mail');
            // }

            return back()->with('success', ucfirst($request->usertype) . ' added successfully');
        } else {
            return back()->with('status', 'Error! ' . $result['message']);
        }
    }

    /**
     * User edit form page
     *
     * @param Quiz $quiz
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function edit(Request $request, User $user)
    {
        if (empty($user) || empty($user->id)) {
            return back()->with('status', 'User not found');
        }

        if ($request->pw && $request->pw > 0) {
            return view('admin.user.change-password', [
                'user' => $user,
            ]);
        }

        return view('admin.user.edit', [
            'user' => $user,
        ]);
    }

    /**
     * Update user according to type
     *
     * @param Request $request
     * @param string $userType
     * @param User $user
     * @return void
     */
    public function update(Request $request, User $user)
    {
        if (empty($user)) {
            return back()->with('status', 'User not found');
        }

        if ($request->pw && $request->pw > 0) {
            return $this->_changePassword($request, $user);
        }

        $this->_validateRequests($request, true);

        try {


            if ($user->mobile != $request->mobile) {
                if (User::where('mobile', $request->mobile)->exists()) {
                    return back()->with('status', 'Sorry! Mobile number already exist with another user');
                }
            }

            $user->name = $request->fullname;
            $user->mobile = $request->mobile;

            $activeStatus = intval($request->status);

            if ($activeStatus > 0 && empty($user->email_verified_at)) {
                $user->email_verified_at = Carbon::now();
                $user->verification_code = null;
                $user->save();
            } elseif ($activeStatus <= 0 && !empty($user->email_verified_at)) {
                $user->email_verified_at = null;
                $user->save();
            }

        } catch (QueryException $ex) {
            return back()->with('status', $ex->getMessage());
        }

        return back()->with('success', 'User profile updated');
    }

    private function _changePassword(Request $request, User $user)
    {
        $this->validate($request, [
            'admin_password' => 'required',
            'new_password' => 'min:6|max:20|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'min:6|max:20',
        ]);

        if (!Hash::check($request->admin_password, auth()->user()->password)) {
            return back()->with('status', 'Incorrect admin password');
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'User password changed successfully');
    }

    /**
     * Validate form requests
     *
     * @param Request $request
     * @return void
     */
    private function _validateRequests(Request $request, bool $update = false)
    {
        $validationRules = [
            'fullname' => 'required|string|max:100',
            'password' => 'required|min:6|max:20',
            'email' => 'required|email|unique:users,email',
            'username' => 'required|string|max:100',
            'mobile' => ['required', 'regex:/^(?:\+88|88)?(01[3-9]\d{8})$/', 'unique:users,mobile'],
            // 'usertype' => Rule::in(User::USER_TYPES),
        ];

        if ($update) {
            unset(
                $validationRules['password'],
                $validationRules['email'],
                $validationRules['username'],
                $validationRules['mobile'],
            );
        }

        $this->validate($request, $validationRules);
    }

}
