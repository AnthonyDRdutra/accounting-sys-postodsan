<?php

namespace Include\clientmodule;

use PDO;

class CRUD_logic
{
    private string $pdo_setup = ("mysql:dbname=dbpostodsan;host=localhost:3306");

    private const login = [
        'default_username' => "root",
        'default_password' => "1234"
        ];

    //pdo setup
    public function PDO_defaults (): PDO
    {
        return new PDO($this -> pdo_setup, self::login['default_username'], self::login['default_password']);
    }


    public function DBbackup(): void
    {
        try {
            // Database connection
            $pdo = $this->PDO_defaults();

            // Set the path where the backup file will be stored
            $backupFilePath = 'C:\Users\antho\OneDrive\Documentos\dbdump';
            $backupFile = $backupFilePath . '/backup_' . date('Ymd_His') . '.sql';

            // Full path to mysqldump executable
            $mysqldumpPath = 'C:\Program Files\MySQL\MySQL Server 8.0\bin\mysqldump.exe';

            // mysqldump command to create a backup (enclose paths in double quotes)
            $command = "\"$mysqldumpPath\" --host=127.0.0.1 --user=root --password=1234 --databases {$pdo->query('select database()')->fetchColumn()} > \"$backupFile\"";

            // Open a process to execute the command
            $descriptors = [
                0 => ['pipe', 'r'],
                1 => ['pipe', 'w'],
                2 => ['pipe', 'w'],
            ];

            $process = proc_open($command, $descriptors, $pipes);

            if (is_resource($process)) {
                // Close the process
                fclose($pipes[0]);
                $output = stream_get_contents($pipes[1]);
                fclose($pipes[1]);
                $errorOutput = stream_get_contents($pipes[2]);
                fclose($pipes[2]);
                $returnCode = proc_close($process);

                // Output both success and error messages
                echo 'Command Output: ' . $output;
                echo 'Error Output: ' . $errorOutput;

                // Check for errors
                if ($returnCode !== 0) {
                    echo 'Error during backup creation. Return Code: ' . $returnCode;
                } else {
                    echo 'Backup created successfully at ' . $backupFile;
                }
            }
        } catch (\PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    //function that return the last ID added to client_books
    public function LastID()
    {
        $pdo = $this->PDO_defaults();
        $sql = $pdo->query("SELECT id FROM client_books ORDER BY id DESC LIMIT 1");

        if ($sql->rowCount() > 0) {
            $lastClientId = $sql->fetch(PDO::FETCH_ASSOC)['id'];
            return $lastClientId;
        }

        return 0; // Return 0 if no records are found
    }

    //autocomplete function, that loads from client_books based on request input
    public function fetchdata($request)
    {
        try {
             $pdo = $this->PDO_defaults();
             $pdo ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

             $sql = $pdo->prepare("SELECT * FROM client_books WHERE client_name LIKE :request");
             $sql->bindValue(':request', '%'. $request. '%', PDO::PARAM_STR);
             $sql->execute();

             $data = array();

             while ($row = $sql->fetch(PDO::FETCH_ASSOC)){
                 $data[] = array(
                   'id' => $row['id'],
                   'client_name' => $row['client_name'],
                 );
             }
             return json_encode($data);
        }catch (\PDOException $e){
            return 'Error: ' .$e->getMessage();
        }
    }

    //function that returns the list of attendees
    public function Attendeelist(): array
    {
        $listArray = [];
        $pdo = $this->PDO_defaults();
        $sql = $pdo -> query("SELECT * FROM dbpostodsan.ateendee_book");
        if ($sql->rowCount()>0) {
            $listArray = $sql -> fetchAll(PDO::FETCH_ASSOC);
        }
        return $listArray;
    }


    //function that return an array with all debt tickets in the database
    public function DebtTicketList():array
    {
        $TicketArray = [];
        $pdo = $this->PDO_defaults();
        $sql = $pdo->query("SELECT * FROM dbpostodsan.client_debt");
        if($sql->rowCount()>0){

            $TicketArray = $sql->fetchAll(PDO::FETCH_ASSOC);

        }
        return $TicketArray;
    }

    //function that returns an array with all the clients in clients_books
    public function ClientList():array
    {
        $ClientArray = [];
        $pdo = $this->PDO_defaults();
        $sql = $pdo->query("SELECT * FROM dbpostodsan.client_books");
        if($sql->rowCount()>0){

            $ClientArray = $sql->fetchAll(PDO::FETCH_ASSOC);

        }
        return $ClientArray;
    }

    //function that returns all the payments tickets on the database
    public function paymentticketlist():array
    {
        $pdo = $this->PDO_defaults();
        $TicketArray = [];
        $pdo = $this->PDO_defaults();
        $sql = $pdo->query("SELECT * FROM dbpostodsan.client_payments");
        if($sql->rowCount()>0){

            $TicketArray = $sql->fetchAll(PDO::FETCH_ASSOC);

        }
        return $TicketArray;

    }

    //function that return the specific debt ticket list of a client based on the $id input
    public function Client_Debt_list($id):array
    {

        $debtListing = [];
        $debtticketArray = $this->DebtTicketList();

        foreach ($debtticketArray as $debtTicket) {
            if($debtTicket['books_id'] == $id)
            {
                $debtListing[] = $debtTicket;
            }
        }
        return $debtListing;
    }


    //function that return the specific payment ticket list of a client based on the $id input
    public function Client_payment_list($id):array
    {

        $paymentListing = [];
        $paymentticket = $this->paymentticketlist();

        foreach ($paymentticket as $payment) {
            if($payment['books_id'] == $id)
            {
                $paymentListing[] = $payment;
            }
        }
        return $paymentListing;
    }

    //function that returns all the debt and payment listed on the database in a list organized by client id
    public function DebtListing():array
    {
        $debtListing = [];
        $clientArray = $this->ClientList();
        $paymentticketArray = $this->paymentticketlist();
        $debtticketArray = $this->DebtTicketList();


        foreach ($clientArray as $client) {
            $clientID = $client['id'];
            $clientname = $client['client_name'];
            $debt = 0;
            $payed =0;

            foreach ($paymentticketArray as $payment){
                if ($payment['books_id'] == $clientID) {
                    $payed += $payment['value'];
                }
            }

            foreach ($debtticketArray as $debtticket) {
                if ($debtticket['books_id'] == $clientID) {
                    $debt += $debtticket['value'];
                }
            }

            $topay = ($debt - $payed);

            if ($debt > 0) {
                $debtListing[] = [
                    'client_id' => $clientID,
                    'client_name' => $clientname,
                    'debt' => $debt,
                    'payed' => $payed,
                    'topay' => $topay,
                ];
            }
        }
        return $debtListing;
    }

    public function LiveDebtListing($input):array
    {
        $debtListing = [];
        $clientArray = $this->ClientList();
        $paymentticketArray = $this->paymentticketlist();
        $debtticketArray = $this->DebtTicketList();

        foreach ($clientArray as $client) {
            $clientID = $client['id'];
            $clientname = $client['client_name'];
            $debt = 0;
            $payed = 0;

            foreach ($paymentticketArray as $payment) {
                if ($payment['books_id'] == $clientID) {
                    $payed += $payment['value'];
                }
            }

            foreach ($debtticketArray as $debtticket) {
                if ($debtticket['books_id'] == $clientID) {
                    $debt += $debtticket['value'];
                }
            }

            $topay = ($debt - $payed);

            // Filter results based on user input
            if ($debt > 0 && strpos($clientname, $input) !== false) {
                $debtListing[] = [
                    'client_id' => $clientID,
                    'client_name' => $clientname,
                    'debt' => $debt,
                    'payed' => $payed,
                    'topay' => $topay,
                ];
            }
        }
        return $debtListing;
    }

    //function that return a debts and payments of a specific client based on their id
    public function Metriclist($id): array
    {
        $totaldebt = $this->Client_Debt_list($id);
        $totalpayment = $this->Client_payment_list($id);
        $debtvalue = 0;
        $paymentvalue = 0;

        foreach ($totaldebt as $debt) {
            $debtvalue += $debt['value'];
        }

        foreach ($totalpayment as $pay) {
            $paymentvalue += $pay['value'];
        }

        $topay = ($debtvalue - $paymentvalue);

        $metric_listing[] =[
            'metric_debts' => $debtvalue,
            'metric_payments' => $paymentvalue,
            'metric_topay' => $topay,
        ];

        return $metric_listing;
    }


    //function that create a debt ticket
    public function CreateDebt($input_name, $input_value, $input_attendee, $input_booksID)
    {
        $pdo = $this->PDO_defaults();
        $currentTimestamp = date("Y-m-d");

        $sql = $pdo->prepare("INSERT INTO dbpostodsan.client_debt(name, ateendee, date, value,books_id) VALUES (:name, :attendee, :date, :value, :books_id)");
        $sql->bindValue(':name', $input_name);
        $sql->bindValue(':attendee', $input_attendee);
        $sql->bindValue(':date', $currentTimestamp);
        $sql->bindValue(':value', $input_value);
        $sql->bindValue(':books_id', $input_booksID);
        $sql->execute();
    }


    //function that create a payment ticket
    public function CreatePayment($input_name, $input_value, $input_attendee, $input_booksID)
    {
        $pdo = $this->PDO_defaults();
        $currentTimestamp = date("Y-m-d");

        $sql = $pdo->prepare("INSERT INTO dbpostodsan.client_payments(name, atendee, date, value,books_id) VALUES (:name, :atendee, :date, :value, :books_id)");
        $sql->bindValue(':name', $input_name);
        $sql->bindValue(':atendee', $input_attendee);
        $sql->bindValue(':date', $currentTimestamp);
        $sql->bindValue(':value', $input_value);
        $sql->bindValue(':books_id', $input_booksID);
        $sql->execute();
    }

    //function that create a new client and verify if already has been added to the database
    public function Create_client($input_name): int
    {
        if($input_name){
            $pdo = $this->PDO_defaults();
            $sql = $pdo->prepare("SELECT * FROM dbpostodsan.client_books WHERE client_name = :client_name");
            $sql->bindValue(':client_name', $input_name);
            $sql->execute();

            if($sql->rowCount() === 0 ){
                $sql =$pdo->prepare("INSERT INTO dbpostodsan.client_books (client_books.client_name) VALUES (:client_name)");
                $sql ->bindValue(':client_name', $input_name);
                $sql -> execute();
                echo 'cadastro realizado com sucesso';
                return 0;
            }else{
                echo 'cliente ja cadastrado';
                return 1;
            }
        }else{
            echo 'nao foi possivel cadastrar';
            return -1;
        }
    }


    public function Delete_client_debt ($id): void
    {
        try{
            $pdo =$this->PDO_defaults();
            $sql = $pdo->prepare("DELETE FROM dbpostodsan.client_debt WHERE id = :id");
            $sql->bindValue(':id', $id, PDO::PARAM_INT);
            $sql->execute();
        }catch (\PDOException $e){
            echo "Error: ".$e->getMessage();
        }
    }

    public function Delete_client_payment ($id): void
    {
        $pdo =$this->PDO_defaults();
        $sql = $pdo->prepare("DELETE FROM dbpostodsan.client_payments WHERE id = :id");
        $sql->bindValue(':id', $id);
        $sql->execute();
    }


}