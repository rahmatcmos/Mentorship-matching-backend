<?php

namespace App\Http\Controllers;

use App\BusinessLogicLayer\managers\MenteeManager;
use App\BusinessLogicLayer\managers\ResidenceManager;
use App\BusinessLogicLayer\managers\SpecialtyManager;
use App\Models\eloquent\MenteeProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MenteeController extends Controller
{
    private $menteeManager;
    private $specialtyManager;
    private $residenceManager;

    public function __construct() {
        $this->specialtyManager = new SpecialtyManager();
        $this->menteeManager = new MenteeManager();
        $this->residenceManager = new ResidenceManager();
    }

    /**
     * Display all mentees.
     *
     * @return \Illuminate\Http\Response
     */
    public function showAllMentees()
    {
        $mentees = $this->menteeManager->getAllMentees();
        $loggedInUser = Auth::user();
        $page_title = 'All mentees';
        return view('mentees.list_all', ['mentees' => $mentees, 'loggedInUser' => $loggedInUser, 'page_title' => $page_title]);
    }

    /**
     * Show the form for creating a new mentee.
     *
     * @return \Illuminate\Http\Response
     */
    public function showCreateForm()
    {
        $mentee = new MenteeProfile();
        $formTitle = 'Mentee registration';
        $specialties = $this->specialtyManager->getAllSpecialties();
        $residences = $this->residenceManager->getAllResidences();

        return view('mentees.forms.create_edit', ['mentee' => $mentee,
            'formTitle' => $formTitle, 'residences' => $residences,
            'specialties' => $specialties
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showEditForm($id)
    {
        $mentee = $this->menteeManager->getMentee($id);

        $specialties = $this->specialtyManager->getAllSpecialties();
        $residences = $this->residenceManager->getAllResidences();

        $formTitle = 'Edit mentee';
        return view('mentees.forms.create_edit', ['mentee' => $mentee,
            'formTitle' => $formTitle, 'residences' => $residences,
            'specialties' => $specialties
        ]);
    }

    /**
     * Store a newly created mentee in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|max:255|email',
            'year_of_birth' => 'required|numeric|min:4|max:4',
            'residence_id' => 'required',
            'address'        => 'required',
            'university_name' => 'required',
            'university_department_name' => 'required',
            'university_graduation_year' => 'required',
            'specialty_experience' => 'required',
            'specialty_id' => 'required',
            'expectations' => 'required',
            'career_goals' => 'required'
        ]);

        $input = $request->all();

        try {
            $this->menteeManager->createMentee($input);
        }  catch (\Exception $e) {
            session()->flash('flash_message_failure', 'Error: ' . $e->getCode() . "  " .  $e->getMessage());
            return back()->withInput();
        }

        session()->flash('flash_message_success', 'Mentee created');
        return $this->showAllMentees();

    }

    /**
     * Display a mentee profile page.
     *
     * @return \Illuminate\Http\Response
     */
    public function showProfile($id)
    {
        $mentee = $this->menteeManager->getMentee($id);
        $loggedInUser = Auth::user();
        return view('mentees.profile', ['mentee' => $mentee, 'loggedInUser' => $loggedInUser]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $this->validate($request, [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|max:255|email',
            'year_of_birth' => 'required|numeric|min:4|max:4',
            'residence_id' => 'required',
            'address'        => 'required',
            'university_name' => 'required',
            'university_department_name' => 'required',
            'university_graduation_year' => 'required',
            'specialty_experience' => 'required',
            'specialty_id' => 'required',
            'expectations' => 'required',
            'career_goals' => 'required'
        ]);

        $input = $request->all();
        try {
            $this->menteeManager->editMentee($input, $id);
        }  catch (\Exception $e) {
            session()->flash('flash_message_failure', 'Error: ' . $e->getCode() . "  " .  $e->getMessage());
            return back()->withInput();
        }

        session()->flash('flash_message_success', 'Mentee edited');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $input = $request->all();
        $menteeId = $input['mentee_id'];
        if($menteeId == null || $menteeId == "") {
            session()->flash('flash_message_failure', 'Something went wrong. Please try again.');
            return back();
        }
        try {
            $this->menteeManager->deleteMentee($menteeId);
        }  catch (\Exception $e) {
            session()->flash('flash_message_failure', 'Error: ' . $e->getCode() . "  " .  $e->getMessage());
            return back();
        }
        session()->flash('flash_message_success', 'Mentee deleted');
        return back();
    }
}
