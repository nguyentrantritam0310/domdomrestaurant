<?php
$currentPath = $_SERVER["REQUEST_URI"];
$path = "";
if (strpos($currentPath, "admin") == true || strpos($currentPath, "manager") == true || strpos($currentPath, "orderstaff") == true || strpos($currentPath, "kitchenstaff") == true)
    $path = "../../../model/mProposals.php";
else $path = "./model/mProposals.php";

if (!class_exists("mProposals"))
    require_once($path);
    
class cProposals extends mProposals
{
    public function cGetAllProposal() {
        if ($this->mGetAllProposal() != 0) {
            $result = $this->mGetAllProposal();
            
            return $result;
        } return 0;
    }
    
    public function cGetProposalByUserID($userID) {
        if ($this->mGetProposalByUserID($userID) != 0) {
            $result = $this->mGetProposalByUserID($userID);
            
            return $result;
        }
    }
    
    public function cInsertProposal($type, $content, $userID) {
        return $this->mInsertProposal($type, $content, $userID);
    }
    
    public function cUpdateStatusProposal($proposalID, $status) {
        if ($this->mUpdateStatusProposal($proposalID, $status) != 0) {
            $result = $this->mUpdateStatusProposal($proposalID, $status);
            
            return $result;
        }
    }
}