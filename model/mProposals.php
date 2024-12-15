<?php

class mProposals
{    
    public function mGetAllProposal() {
        $db = new Database;
        $conn = $db->connect();
        $sql = "SELECT * FROM proposal";
        
        if ($conn != null)
            return $conn->query($sql);
        return 0;
    }
    
    public function mGetProposalByUserID($userID) {
        $db = new Database;
        $conn = $db->connect();
        $sql = "SELECT *,P.status FROM proposal AS P JOIN user AS U ON P.userID = U.userID";
        
        if ($conn != null)
            return $conn->query($sql);
        return 0;
    }
    
    public function mInsertProposal($type, $content, $userID) {
        $db = new Database;
        $conn = $db->connect();
        $sql = "INSERT INTO proposal (typeOfProposal, content, status, userID) VALUES ('$type', '$content', 0, '$userID')";
        
        if ($conn != null)
            return $conn->query($sql);
        return 0;
    }
    
    public function mUpdateStatusProposal($proposalID, $status) {
        $db = new Database;
        $conn = $db->connect();
        $sql = "UPDATE proposal SET status = $status WHERE proposalID = $proposalID";
        
        if ($conn != null)
            return $conn->query($sql);
        return 0;
    }
}