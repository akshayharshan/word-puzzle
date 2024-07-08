<?php
class Game
{
    private $letters;
    private $userWords;
    private $score;
    private $dictionaryURL;
    private $englishWordsList;
    private $tablename = 'ranks';
    private $result;


    public function __construct()
    {

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
         }
        // Initialize game data
        if (!isset($_SESSION['letters'])) {
            $_SESSION['letters'] = 'sitsatgate'; // Example string
            $_SESSION['user_words'] = [];
            $_SESSION['score'] = 0;
        }

        $this->letters = $_SESSION['letters'];
        $this->userWords = $_SESSION['user_words'];
        $this->score = $_SESSION['score'];
        $this->dictionaryURL = 'https://api.dictionaryapi.dev/api/v2/entries/en';
        // define possible words that can be created using the random letters we provide
        $this->englishWordsList =['gate','sat','sit']; 
    }



    public function insertScore($score, $wordList)
    {

        try {
            $instance = DbConnect::getInstance();
            $conn = $instance->getConnection();
            $stmt = $conn->prepare("INSERT INTO $this->tablename (scores,words) VALUES (?,?)");
            $stmt->bind_param("ss", $score, $wordList);
            $stmt->execute();
            $stmt->close();
            $conn->close();
        } catch (Exception $e) {

            echo "Error: " . $e->getMessage();
        }
    }

    public function processInput($word)
    {

        $word = strtolower(trim($word));
        $lettersToArray = str_split($this->letters);

        if ($this->CheckWord($word) == TRUE && !in_array($word, $this->userWords) && in_array($word,$this->englishWordsList)) {
            $this->userWords[] = $word;
            $wordArray = str_split($word);
            foreach($wordArray as $word){

                if (($key = array_search($word, $lettersToArray)) !== false) {
                    unset($lettersToArray[$key]);
                }
            }
            
            
            $getWordsLeft = array_values($lettersToArray);;
            //print_r($getWordsLeft);die;
            
            $this->letters = implode("", $getWordsLeft);
            
            $this->score += 3;

            $_SESSION['letters'] = $this->letters;
            $_SESSION['user_words'] = $this->userWords;
            $_SESSION['score'] = $this->score;

            if (empty($this->letters)) {
                $this->endGame();
            }
        }
    }

    public function endGame()
    {
        $wordsList = json_encode($this->userWords);
        // check the score is greater than 0
        if ($this->score > 0) {
            $this->insertScore($this->score, $wordsList);
        }
        // store result in another session variable
        $this->result=$_SESSION['user_words'];
        $_SESSION['result'] = $this->result;
        unset($_SESSION['letters']);
        unset($_SESSION['user_words']);
        unset($_SESSION['score']);
        
        //session_destroy();
        header("Location: ResultPage.php", true, 200);
        exit;
    }


    public function getData()
    {
        try {
            $instance = DbConnect::getInstance();
            $conn = $instance->getConnection();
            $sql = "SELECT * FROM $this->tablename ORDER BY scores DESC LIMIT 10";
            $result = $conn->query($sql);
            $rank = 1;
            if ($result->num_rows > 0) {
                // output data of each row
                while ($row = $result->fetch_assoc()) {
                    $wordCollect = json_decode($row['words']);
                    $wordString = implode(',', $wordCollect);


                    echo "<tr>
                        <td>" . $rank . "</td>
                        <td>" . $row['scores'] . "</td>
                        <td>" . $wordString . "</td>

                    </tr>";
                    $rank++;
                }
            }
            $conn->close();
        } catch (Exception $e) {

            echo "Error :" . $e->getMessage();
        }
    }

    public function  CheckWord($word)
    {

        try {

            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => $this->dictionaryURL . '/' . $word,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => [
                    "Accept: application/json"
                ],
            ]);
            $response = curl_exec($curl);
            curl_close($curl);
            $data = json_decode($response);
            if (isset($data->title)) {
                return FALSE;
            }
            return TRUE;
        } catch (Exception $e) {

            echo "Error :" . $e->getMessage();
        }
    }


    public function remainWords($result){
        // we can pass the possible word combinations here to comapre
            $wordsLeft = array_diff($this->englishWordsList,$result);
            $result = implode(',',$wordsLeft);
            return $result;

    }
}
