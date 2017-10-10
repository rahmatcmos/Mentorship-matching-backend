<?php

namespace App\StorageLayer;

use App\BusinessLogicLayer\managers\UserAccessManager;
use App\Models\eloquent\AccountManagerCapacity;
use App\Models\eloquent\MentorshipSessionHistory;
use App\Models\eloquent\User;
use App\Utils\MentorshipSessionStatuses;

/**
 * Class UserStorage
 * @package app\StorageLayer
 *
 * Contains the eloquent queries methods for the Users.
 */
class UserStorage {

    public function saveUser(User $user) {
        $user->save();
        return $user;
    }

    public function getAllUsers() {
        return User::all();
    }

    public function getUserById($id) {
        return User::find($id);
    }

    public function saveAccountManagerCapacity(AccountManagerCapacity $accountManagerCapacity) {
        $accountManagerCapacity->save();
        return $accountManagerCapacity;
    }

    public function getAccountManagerCapacityById($accountManagerId) {
        return AccountManagerCapacity::where(['account_manager_id' => $accountManagerId])->first();
    }

    public function getUsersThatMatchGivenNameOrEmail($searchQuery) {
        return User::where('first_name', 'like', '%' . $searchQuery . '%')
            ->orWhere('last_name', 'like', '%' . $searchQuery . '%')
            ->orWhere('email', 'like', '%' . $searchQuery . '%')->get();
    }

    public function getAccountManagersWithRemainingCapacity() {
        $mentorshipSessionStatuses = new MentorshipSessionStatuses();
        $userAccessManager = new UserAccessManager();
        $rawQueryStorage = new RawQueryStorage();
        $result = $rawQueryStorage->performRawQuery("
           select u.*, ur.user_id, capacity, (capacity - IFNULL(total_active_sessions,0)) as remainingCapacity from 
                user_role ur
                inner join account_manager_capacity amc on amc.account_manager_id = ur.user_id
                inner join users u on u.id = ur.user_id
                left outer join          
                        (select ms.account_manager_id, count(*) as total_active_sessions  -- count how many active sessions exist per account manager
                            from  mentorship_session ms 
                            inner join   -- find sessions that have not yet completed
                                (
									select msh.mentorship_session_id ,
										msh.status_id as LastSessionStatus from 
									mentorship_session_history msh inner join
								(
									select mentorship_session_id, 
											max(id) as last_mentorship_session_history_id
										from mentorship_session_history as msh
										group by mentorship_session_id
								   ) LastSessionHistoryRecord on LastSessionHistoryRecord.last_mentorship_session_history_id = msh.id
									where msh.status_id  in (" . implode(",", $mentorshipSessionStatuses::getActiveSessionStatuses()) . ")

                                ) as NonCompletedSessions on ms.id = NonCompletedSessions.mentorship_session_id
                            where ms.deleted_at is null 
                            group by ms.account_manager_id 
                         ) as activeAccountManagerSessions on activeAccountManagerSessions.account_manager_id = ur.user_id
            where ur.role_id = $userAccessManager->ACCOUNT_MANAGER_ROLE_ID and u.deleted_at is null and u.state_id = 1
        ");
        return $result;
    }

    public function getUsersFromIdsArray(array $ids) {
        return User::whereIn('id', $ids)->get();
    }
}
