<?php

    class Pagination{

        public $page;
        public $limit;
        public $offset;
        public $search;
        public $orderBy;
        public $order;

        public function __construct($orderBy = array()){

            $this->page       = (isset($_GET["page"]))? intval($_GET["page"]):1;
            $this->page       = $this->page<=0? 1:$this->page;

            $this->limit      = (isset($_GET["limit"]))? intval($_GET["limit"]):20;
            $this->limit       = $this->limit<=0? 1:$this->limit;

            $this->offset     = intval(($this->page - 1) * $this->limit);
            $this->search     = (isset($_GET["search"]))? $_GET["search"]:"";
            $this->orderBy    = (isset($_GET["orderBy"]) && in_array($_GET["orderBy"], $orderBy))? $_GET["orderBy"]:"id";
            $this->order      = (isset($_GET["order"]) && $_GET["order"]=="ASC")? "ASC":"DESC";
        }

        public function Get($db, $table, $columns){

            $total            = $db->select("SELECT COUNT(*) AS count
                                                    FROM ".$table."
                                                    WHERE firstname LIKE :search
                                                    ORDER BY ".$this->orderBy." ".$this->order." 
                                                    LIMIT ".$this->limit." OFFSET ".$this->offset.";", 
                                                    array(":search" => "%".$this->search."%"));

            $results          = $db->select("SELECT ".$columns."
                                             FROM ".$table."
                                             WHERE firstname LIKE :search
                                             ORDER BY ".$this->orderBy." ".$this->order." 
                                             LIMIT ".$this->limit." OFFSET ".$this->offset.";", 
                                             array(":search" => "%".$this->search."%"));

            return array("Total" => isset($total[0])? intval($total[0]["count"]):0, "Results" => $results);
        }
    }
?>