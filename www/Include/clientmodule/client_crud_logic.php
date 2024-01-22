<?php


namespace Include\clientmodule;

use PDO;

class client_crud_logic
{
    private string $pdo_setup = ("mysql:dbname=dbpostodsan;host=localhost:3306");

    private const login = [
        'default_username' => "root",
        'default_password' => "1234"
    ];

    //pdo setup
    public function PDO_defaults(): PDO
    {
        return new PDO($this->pdo_setup, self::login['default_username'], self::login['default_password']);
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
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = $pdo->prepare("SELECT * FROM client_books WHERE client_name LIKE :request");
            $sql->bindValue(':request', '%' . $request . '%', PDO::PARAM_STR);
            $sql->execute();

            $data = array();

            while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
                $data[] = array(
                    'id' => $row['id'],
                    'client_name' => $row['client_name'],
                );
            }
            return json_encode($data);
        } catch (\PDOException $e) {
            return 'Error: ' . $e->getMessage();
        }
    }


    //function that returns the list of attendees
    public function Attendeelist(): array
    {
        $listArray = [];
        $pdo = $this->PDO_defaults();
        $sql = $pdo->query("SELECT * FROM dbpostodsan.ateendee_book");
        if ($sql->rowCount() > 0) {
            $listArray = $sql->fetchAll(PDO::FETCH_ASSOC);
        }
        return $listArray;
    }


    public function ticketlist($type): array
    {
        switch ($type) {

            //case debt list
            case 0:
                $query = 'SELECT * FROM dbpostodsan.client_debt';
                break;

            //case payment list
            case 1:
                $query = 'SELECT * FROM dbpostodsan.client_payment';
                break;

            //case client book list
            case 2:
                $query = 'SELECT * FROM dbpostodsan.client_books';
        }

        $array = [];
        $pdo = $this->PDO_defaults();
        $sql = $pdo->query($query);
        if ($sql->rowCount() > 0) {

            $array = $sql->fetchAll(PDO::FETCH_ASSOC);

        }
        return $array;
    }


    //function that return the specific ticket of the list based on the $id and $type input
    public function Client_payment_and_debt_list($id, $type): array
    {
        $Listing = [];
        $ticket = $this->ticketlist($type);

        foreach ($ticket as $payment) {
            if ($payment['books_id'] == $id) {
                $paymentListing[] = $payment;
            }
        }
        return $paymentListing;
    }


    //function that returns all the debt and payment listed on the database in a list organized by client id
    public function DebtListing(): array
    {
        $debtListing = [];
        $clientArray = $this->ticketlist(2);
        $paymentticketArray = $this->ticketlist(1);
        $debtticketArray = $this->ticketlist(0);


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


    public function LiveDebtListing($input): array
    {
        $debtListing = [];
        $clientArray = $this->ticketlist(2);
        $paymentticketArray = $this->ticketlist(1);
        $debtticketArray = $this->ticketlist(0);

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
        $totaldebt = $this->Client_payment_and_debt_list($id, 0);
        $totalpayment = $this->Client_payment_and_debt_list($id, 1);
        $debtvalue = 0;
        $paymentvalue = 0;

        foreach ($totaldebt as $debt) {
            $debtvalue += $debt['value'];
        }

        foreach ($totalpayment as $pay) {
            $paymentvalue += $pay['value'];
        }

        $topay = ($debtvalue - $paymentvalue);

        $metric_listing[] = [
            'metric_debts' => $debtvalue,
            'metric_payments' => $paymentvalue,
            'metric_topay' => $topay,
        ];

        return $metric_listing;
    }


    //function that create a debt or payment ticket
    public function Create_Debt_or_Payment($input_name, $input_value, $input_attendee, $input_booksID, $type)
    {
        switch ($type) {
            //case debt
            case 0:
                $query = 'INSERT INTO dbpostodsan.client_debt(name, attendee, date, value,books_id) VALUES (:name, :attendee, :date, :value, :books_id)';
                break;
            //case payment
            case 1:
                $query = 'INSERT INTO dbpostodsan.client_payments(name, attendee, date, value,books_id) VALUES (:name, :attendee, :date, :value, :books_id)';
                break;
        }

        $pdo = $this->PDO_defaults();
        $currentTimestamp = date("Y-m-d");

        $sql = $pdo->prepare("");
        $sql->bindValue(':name', $input_name);
        $sql->bindValue(':attendee', $input_attendee);
        $sql->bindValue(':date', $currentTimestamp);
        $sql->bindValue(':value', $input_value);
        $sql->bindValue(':books_id', $input_booksID);
        $sql->execute();
    }


    //function that create a new client and verify if already has been added to the database
    public function Create_client($input_name): int
    {
        if ($input_name) {
            $pdo = $this->PDO_defaults();
            $sql = $pdo->prepare("SELECT * FROM dbpostodsan.client_books WHERE client_name = :client_name");
            $sql->bindValue(':client_name', $input_name);
            $sql->execute();

            if ($sql->rowCount() === 0) {
                $sql = $pdo->prepare("INSERT INTO dbpostodsan.client_books (client_books.client_name) VALUES (:client_name)");
                $sql->bindValue(':client_name', $input_name);
                $sql->execute();
                echo 'cadastro realizado com sucesso';
                return 0;
            } else {
                echo 'cliente ja cadastrado';
                return 1;
            }
        } else {
            echo 'nao foi possivel cadastrar';
            return -1;
        }
    }


    public function Delete_client_debt_or_payment($id, $type): void
    {

        switch ($type) {
            case 0:
                $query = 'DELETE FROM dbpostodsan.client_debt WHERE id = :id';
                break;
            case 1:
                $query = 'DELETE FROM dbpostodsan.client_payments WHERE id = :id';
                break;
        }

        try {
            $pdo = $this->PDO_defaults();
            $sql = $pdo->prepare($query);
            $sql->bindValue(':id', $id, PDO::PARAM_INT);
            $sql->execute();
        } catch (\PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}