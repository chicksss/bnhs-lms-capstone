<?php


class ARCHIVE extends ArchiveDB{


    public function getAllArchive(){
        $sql = 'SELECT * FROM archives';
        $stmt = $this->connect()->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
}


?>