<?php
class Settings{

  var $input; // Array
  var $settingsList = array(); // Array
  var $return; // Array
  var $db_return; // Array
  var $backup; // Array - a buckup of the $settings

  // array with default values
  var $settings = [
          'general_tokenLenght' => 50,    // number of chars in the token string
          'general_maximalSessionTime' => 3, // int in minutes
          'users_minimumRoleDelete' => 4, // the minimum role you need to have in order to delete a user entry from db
          'users_minimumRoleAdd' => 4, // the minimum role you need to have in order to add a user entry to db
          'users_minimumRoleEdit' => 4, // the minimum role you need to have in order to edit a user entry in db
          'magazine_minimumRoleDelete' => 2, // the minimum role you need to have in order to delete a product entry from db
          'magazine_minimumRoleAdd' => 2, // the minimum role you need to have in order to add a product entry to db
          'magazine_minimumRoleEdit' => 2, // the minimum role you need to have in order to edit a product entry in db
        ];

  public function __construct($input_from_control,$settingsList){

    // saves the initial $this->settings array in case of a reset
    $this->backup = $this->settings;

    $this->settingsList = $settingsList;
    $this->input = $input_from_control;

    // loads values from db and overwrites default values
    $this->applyDb($settingsList);

    if(isset($this->input['settings_initial'])){
      if($this->input['settings_initial']){
        // the class is called in control->__construct()

        // reset
        if(isset($this->input['settings'])){
          if($this->input['settings'] == "reset"){
            $this->reset();
          }
        }

      }else{
        // the class is called in control->handleInput()
        $this->handleInput($this->input);
      } // end if 2
    } // end if 1
  } // end construct()

/**
  * processes the input from the control class
  * @param Array input
  */
private function handleInput($input){
    // DEBUG:
    // echo "opened settingssssss<br>";
    // echo "handleInout(): var_dump($this->settingsList);:<br>";
    // var_dump($this->settingsList);
    // echo "<br><br>";

  // switch to do different actions
  if(isset($input['settings'])){
    switch ($input['settings']){
      case 'changeSetting':
        $this->changeSetting($input['setting'],$input['old_security_level'],$input['security_level'],$input['value'],$input['description']);
        break;
      case 'reset':
        $this->reset();
        break;
      default:
        $this->show_settings($this->settingsList);
        break;
    }
  }else{
    $this->show_settings($this->settingsList);
  } // end if
} // end handleInput()

/**
  * function to display the settings
  * @param Array settingsList
  */
private function show_settings($settingsList){
  // echo "show_settingsList:<br>";
  // var_dump($settingsList);
  // echo "<br><br>";
  $this->return['settingsList'] = $settingsList;
} // end show_settings

/**
  * function edits a setting
  * @param int settingID
  * @param int old_security_level
  * @param int new_security_level
  * @param int new_value
  * @param String new_description
  */
private function changeSetting($settingId,$old_security_level,$new_security_level,$new_value,$new_description){
  echo "<br>change setting: ".$settingId."<br>";

  // check wheter user has the permission to adjust that setting
  if($this->checkPermission($old_security_level)){

    if($this->checkPermission($new_security_level)){

      // change db
      echo "setting changed!<br>";

      $query = 'UPDATE `settings` SET ';
      $komma = false;
      if($new_security_level != null){
        $query = $query.'`security_level`=\''.$new_security_level.'\'';
        $komma = true;
      }

      if($new_value != null){
        if($new_value >= 0){
          if($komma==true){
            $query = $query.',';
          }
          $query = $query.'`value`=\''.$new_value.'\'';
          $komma = true;
        }else{
          $this->alert("The value has to be >= 0!");
        }
      }else{
        // $komma = false;
      }

      if($new_description != null){
        if($komma==true){
          $query = $query.',';
        }
        $query = $query.'`description`=\''.$new_description.'\'';
      }

      $query = $query.' WHERE `ID` = '.$settingId;

      // var_dump($query);

      $this->db_return['action'] = "change";
      $this->db_return['change'] = $query;

    }else{
      $this->alert("You cannot asasign a setting a higher security level as your own role!");
      $this->reload();
    } // end if 2

  }else{
    $this->alert("Your role is insufficient to adjust that setting!");
    $this->reload();
  } // end if 1

}

/**
  * function to change the classVars to the values from DB
  * @param Array settingsList
  */
private function applyDb($settingsList){
  // if(isset($this->input['settings_initial'])){
  //   if($this->input['settings_initial']){
      // the class is called in control->__construct() --> that means without debug

      // matches each setting in the settings array with the db entry and changes it to db's value
      foreach ($this->settings as $key => $value) {
        $newValue;

        foreach ($settingsList as $keySettingsList => $valueSettingsList) {
          if($key == $settingsList[$keySettingsList][1]){
            $newValue = $settingsList[$keySettingsList][2];
            break;
          } // end if
        } // end forech 2

        if(isset($newValue)){
          $this->settings[$key] = $newValue;
        }else{
          //sth is wrong with a setting's name
        } // end if

      } // end forech 1

    // }else{
    //   echo "applyDb()<br>";
    //   // the class is called in control->handleInput()
    //
    //   // DEBUG:
    //   echo "settingsList:<br>";
    //   var_dump($settingsList);
    //   echo "<br><br>";
    //   echo "settings:<br>";
    //   var_dump($this->settings);
    //
    //   // matches each setting in the settings array with the db entry and changes it to db's value
    //   foreach ($this->settings as $key => $value) {
    //     // echo "test:$key<br>";
    //     $newValue;
    //
    //     foreach ($settingsList as $keySettingsList => $valueSettingsList) {
    //       if($key == $settingsList[$keySettingsList][1]){
    //         $newValue = $settingsList[$keySettingsList][2];
    //         break;
    //       } // end if
    //     } // end forech 2
    //
    //       if(isset($newValue)){
    //
    //         // DEBUG:
    //         // echo "<br><br>";
    //         // echo "<br>this->settings[\$key]: ";
    //         // var_dump($this->settings[$key]);
    //         // echo "<br>\$newValue: ";
    //         // var_dump($newValue);
    //
    //         $this->settings[$key] = $newValue;
    //       }else{
    //         $this->alert("sth is wrong with a setting's name");
    //       } // end if
    //
    //     } // end forech 1
    //
    //   } // end if 2
    // } // end if 1

} // end applyDb()

/**
  * function to check wheter the user has the permission to change a specific setting
  * @param int settingID
  */
private function checkPermission($security_level){
  if($this->compareRole($security_level)){
    return true;
  }else{
    return false;
  } // end if
} // end checkPermission()

/**
  * function to compare necessary role status with user
  * returns true if role status is high enough
  * @param int role_needed
  */
private function compareRole($role_needed){
  if ($role_needed <= $_SESSION['role']) {
    return true;
  } else {
    return false;
  }
} // end compareRole()

/**
  * function to reset all settings to default values
  */
public function reset(){
  // set db values to default values from the $this->settings Array
  $backup = $this->backup;

  $this->alert("RESET!!!");

  $this->db_return['action'] = "reset";
  $this->db_return['backup'] = $backup;

  // UPDATE `settings` SET `value`=[value-3] WHERE `setting`

} // end reset()

/**
  * sends an alert to the user
  * @param String message
  */
private function alert($message){
  ?><!DOCTYPE html>
  <html>
    <head>
    </head>
    <body>

    </body>
    <script type="text/javascript">
      alert("<?php echo $message; ?>");
    </script>
  </html>
  <?php
} // end alert()

/**
  * reloads http://susocafe.bplaced.net/index.php?action=open_settings
  */
private function reload(){
  ?>
  <!-- this reloads the page so that the change can be seen in the html output -->
  <!DOCTYPE html>
  <html>
    <script type="text/javascript">
      location.replace("http://susocafe.bplaced.net/index.php?action=open_settings");
    </script>
  </html>
  <?php
} // end reload

} // end Settings
?>
