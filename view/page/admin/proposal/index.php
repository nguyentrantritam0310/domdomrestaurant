<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ctrl = new cProposals;
    $ctrlMessage = new cMessage;

    $proposalID = $_POST["proposalID"];
    $status = $_POST["status"];

    if ($ctrl->cUpdateStatusProposal($proposalID, $status) != 0) {
        $ctrl->cUpdateStatusProposal($proposalID, $status);
        $ctrlMessage->successMessage("Cập nhật trạng thái đề xuất ");
    } else
        $ctrlMessage->errorMessage("Cập nhật trạng thái đề xuất ");
}
?>
<div class="grid grid-cols-1 md:grid-cols-1 gap-6 mt-8">
    <div class="bg-white p-6 rounded-lg shadow-lg mb-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold">
                Danh sách đề xuất
            </h2>
            <div class="flex items-center">
                <button class="btn bg-green-100 text-green-500 py-2 px-4 rounded-lg mr-1 hover:bg-green-500 hover:text-white">Xuất <i class="fa-solid fa-table"></i></button>
                <button class="btn bg-blue-100 text-blue-500 py-2 px-4 rounded-lg ml-1 hover:bg-blue-500 hover:text-white">In <i class="fa-solid fa-print"></i></button>
            </div>
        </div>
        <div class="h-fit bg-gray-100 rounded-lg p-6">
            <table class="text-base w-full text-center">
                <thead>
                    <tr>
                        <th class="text-gray-600 border-2 py-2 w-40">Người đề xuất</th>
                        <th class="text-gray-600 border-2 py-2 w-52">Loại đề xuất</th>
                        <th class="text-gray-600 border-2 py-2">Nội dung</th>
                        <th class="text-gray-600 border-2 py-2 w-32">Trạng thái</th>
                        <th class="text-gray-600 border-2 py-2 w-48">Chức năng</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT *, P.status FROM proposal AS P JOIN user AS U ON P.userID = U.userID";
                    $result = $conn->query($sql);

                    while ($row = $result->fetch_assoc()) {
                        if ($row["status"] == 1) {
                            $statusLabel = "Đã duyệt";
                            $statusClass = "bg-green-100 text-green-500";
                        } elseif ($row["status"] == 2) {
                            $statusLabel = "Từ chối";
                            $statusClass = "bg-yellow-100 text-yellow-500";
                        } else {
                            $statusLabel = "Chờ duyệt";
                            $statusClass = "bg-red-100 text-red-500";
                        }

                        echo "
                            <tr id='proposal-" . $row["proposalID"] . "'>
                                <td class='py-2 border-2'>" . $row["userName"] . "</td>
                                <td class='py-2 border-2'>" . $row["typeOfProposal"] . "</td>
                                <td class='py-2 border-2'>" . $row["content"] . "</td>
                                <td class='py-2 border-2'>
                                    <span class='" . $statusClass . " py-1 px-2 rounded-lg'>" . $statusLabel . "</span>
                                </td>
                                <td class='py-2 border-2 flex justify-center'>
                                    <!-- Form Từ chối -->
                                    <form action='' method='POST' style='display: inline-block;'>
                                        <input type='hidden' name='proposalID' value='" . $row["proposalID"] . "'>
                                        <input type='hidden' name='status' value='2'> <!-- Từ chối -->
                                        <button type='submit' class='btn btn-secondary mr-1' " . ($row["status"] != 0 ? "disabled" : "") . ">Từ chối</button>
                                    </form>
                                    <!-- Form Duyệt -->
                                    <form action='' method='POST' style='display: inline-block;'>
                                        <input type='hidden' name='proposalID' value='" . $row["proposalID"] . "'>
                                        <input type='hidden' name='status' value='1'> <!-- Duyệt -->
                                        <button type='submit' class='btn btn-danger ml-1' " . ($row["status"] != 0 ? "disabled" : "") . ">Duyệt</button>
                                    </form>
                                </td>
                            </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>