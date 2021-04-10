<?php 
    class ModeratorCheckModel {
        
        private function getUserClientToken() {
            $user_agent = $_SERVER['HTTP_USER_AGENT'];
            
            $ip = null;
            if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } else {
                $ip = $_SERVER['REMOTE_ADDR'];
            }

            $token = $ip . ":" . $user_agent;
            return $token;
        }

        public function isUserAuthenticated() {
            $isSessionValid = $this->validateSession();
            $isUserValid = $this->validateUser();

            if( $isSessionValid && $isUserValid) {
                return true;
            }
            return false;
        }

        private function validateSession() {
            $currentToken = $this->getUserClientToken();
          
            if( isset( $_SESSION['CLIENT_PC']) ) {
                if( $currentToken == $_SESSION['CLIENT_PC']) {
                    return true;
                }
            } else {
                $_SESSION['CLIENT_PC'] = $currentToken; 
                return true;
            }
            
            return false;
        }

        private function validateUser() {
            include("connect-db.php");

            $id = base64_decode( $_SESSION['LOGIN_MODERATOR']);
            $userQuery = "SELECT id FROM design_event_moderator WHERE id = $id LIMIT 1";
            $result = mysqli_query($db, $userQuery);
            $moderatorRow = mysqli_fetch_assoc($result);
            // if Moderator exists
            if( $moderatorRow) {
                return true;
            }else{
                return false;
            }
            
        } 
    }

?>