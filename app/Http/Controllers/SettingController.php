<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Repositories\SettingRepository;

class SettingController extends Controller
{
    private $settingRepository;

    public function __construct(SettingRepository $settingRepository)
    {
        parent::__construct();
        $this->settingRepository = $settingRepository;
    }

    public function index()
    {
        $settings = $this->settingRepository->index();

        return view('setting.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $this->settingRepository->update($request);

        return redirect()->route('settings.index')->with('success', 'Settings updated successfully');
    }
}
