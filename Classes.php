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
        if(!file_exists("all_users.txt")) touch("all_users.txt");
        $was_saved_successfull = file_put_contents("all_users.txt", $serialized);
        if(!$was_saved_successfull) throw new Exception("Error: File was not saved");
    }
    public static function GetDB(): array {
        $result = file_get_contents("all_users.txt");
        if($result === false) return [];
        return unserialize($result);
    }
    public static function FindByUsername(string $username): User {
        $db = AccountManager::GetDB();
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

    public static function AddUser(User $user) {
        self::$UsersList = self::GetDB();
        self::$UsersList[] = $user;
        self::SaveToFile();
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
}
$accountsManager = new AccountManager();
?>