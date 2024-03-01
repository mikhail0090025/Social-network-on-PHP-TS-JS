<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function Alert($obj) {
    echo "<script>alert(" . $obj . ");</script>";
}
class AccountManager{
    public static array $UsersList = [];

    public static function SaveToFile() {
        $serialized = serialize(self::$UsersList);
        //if(!file_exists("all_users.txt")) touch("all_users.txt");
        //$file = fopen("all_users.txt", "w");
        //fwrite($file, $serialized);
        file_put_contents("all_users.txt", $serialized);
        echo $serialized;
        //fclose($file);
    }

    // Get users from file
    public static function GetDB(): array {
        if(filesize("all_users.txt") == 0 || !file_exists("all_users.txt")) {
            echo "Empty list was returned!";
            return [];
        }
        $file = fopen("all_users.txt", "r");
        $text = fread($file, filesize("all_users.txt"));
        $result = unserialize($text);
        self::$UsersList = $result;
        fclose($file);
        return $result;
    }
    public static function FindByUsername(string $username): User {
        $db = self::GetDB();
        foreach ($db as $user) {
            if($user->Username == $username) return $user;
        }
        throw new Exception("Profil with username " . $username . " was not found");
    }

    // Checks if some username is not in DB, and we can use it for new user
    public static function UsernameIsFree(string $username_): bool {
        try {
            $user = self::FindByUsername($username_);
        } catch (\Throwable $th) {
            return true;
        }
        return false;
    }

    public static function AddUser(User $user): bool {
        if(!self::UsernameIsFree($user->Username)){
            echo "Username is busy. " . $user->Username;
            return false;
        }
        self::GetDB();
        self::$UsersList[] = $user;
        self::SaveToFile();
        return true;
    }

    public static function DeleteUser(string $username){
        self::$UsersList = self::GetDB();
        $user = self::FindByUsername($username);
        $index = array_search($user, self::$UsersList);
        if($index == false) return;
        unset(self::$UsersList[$index]);
        self::SaveToFile();
    }

    public static function UpdateUser(User $user){
        $u = self::FindByUsername($user->Username);
        $index = array_search($u, self::$UsersList);
        if($index == false) throw new Exception("User was not found and updated!");
        self::$UsersList[$index] = $user;
        self::SaveToFile();
    }

    // This void adds some users for tests
    public static function AddDefaultUsers(){

        // New users
        $user1 = new User("user111", password_hash("Password_user111", 0), new DateTime("2001-02-05"), "I am user111 for test");
        $user2 = new User("user112", password_hash("Password_user112", 0), new DateTime("2001-05-04"), "I am user112 for test");
        $user3 = new User("user113", password_hash("Password_user113", 0), new DateTime("2008-09-23"), "I am user113 for test");
        $user4 = new User("user114", password_hash("Password_user114", 0), new DateTime("2014-01-22"), "I am user114 for test");
        
        // Delete test users if exist
        self::DeleteUser($user1->Username);
        self::DeleteUser($user2->Username);
        self::DeleteUser($user3->Username);
        self::DeleteUser($user4->Username);

        // Adding them to list
        self::AddUser($user1);
        self::AddUser($user2);
        self::AddUser($user3);
        self::AddUser($user4);
        $user1->AddFriend($user3->Username);
        $user1->AddFriend($user2->Username);
        echo sizeof(self::$UsersList);
    }
}
class User{
    public string $Username;
    public string $EncryptedPassword;
    public DateTime $Birthday;
    public string $Bio;
    public array $Friends;
    public function __construct(string $Username, string $EncryptedPassword, DateTime $Birthday, string $Bio) {
        $this->Username = $Username;
        $this->EncryptedPassword = $EncryptedPassword;
        $this->Birthday = $Birthday;
        $this->Bio = $Bio;
        $this->Friends = [];
    }

    public function AddFriend(string $friend_name){
        if(in_array($friend_name, $this->Friends)) return;
        echo "<p>Friend added $friend_name</p>";
        $new_friend = AccountManager::FindByUsername($friend_name);
        $this->Friends[] = $friend_name;
        AccountManager::UpdateUser($this);
        $new_friend->AddFriend($this->Username);
        AccountManager::UpdateUser($new_friend);
    }

    public function RemoveFriend(string $friend_name){
        if(in_array($friend_name, $this->Friends)) return;
        echo "<p>Friend removed $friend_name</p>";
        $removed_friend = AccountManager::FindByUsername($friend_name);
        $index = array_search($friend_name, $this->Friends);
        if($index !== false){
            unset($this->Friends[$index]);
            AccountManager::UpdateUser($this);
            $removed_friend->RemoveFriend($this->Username);
            AccountManager::UpdateUser($removed_friend);
        }
        else echo "User $friend_name is not in list!";
    }

    public function AreFriends(string $username_) : bool {
        // debug
        echo "Friends array: " . print_r($this->Friends, true) . "<br>";
        echo "Username to check: " . $username_ . "<br>";

        return in_array($username_, $this->Friends);
    }
}
?>