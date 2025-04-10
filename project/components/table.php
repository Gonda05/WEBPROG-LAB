<?php
function render_table($result, $actions = []) {
    if (!$result || mysqli_num_rows($result) == 0) {
        echo "<p class='text-gray-600'>Tidak ada data untuk ditampilkan.</p>";
        return;
    }

    // Determine current sort and direction
    $currentSort = $_GET['sort'] ?? '';
    $currentDir = strtolower($_GET['dir'] ?? 'asc');
    $newDir = ($currentDir === 'asc') ? 'desc' : 'asc';

    echo "<div class='relative overflow-x-auto shadow-md sm:rounded-lg mt-4'>";
    echo "<table class='w-full text-sm text-left rtl:text-right text-gray-500'>";
    
    // Table Head
    echo "<thead class='text-base text-gray-700 uppercase bg-[#D58E1D]'>";
    echo "<tr>";
    while ($fieldinfo = mysqli_fetch_field($result)) {
        $fieldName = $fieldinfo->name;

        // Build sort URL with current GET params
        $params = $_GET;
        $params['sort'] = $fieldName;
        $params['dir'] = (($_GET['sort'] ?? '') === $fieldName && ($_GET['dir'] ?? 'asc') === 'asc') ? 'desc' : 'asc';
        $sortUrl = '?' . http_build_query($params);

        echo "<th scope='col' class='px-6 py-3 text-[#F1EEEE]'>";
        echo "<div class='flex items-center'>";
        echo "<a href=\"$sortUrl\" class='flex items-center hover:underline'>" . ucfirst($fieldName) . "
            <svg class='w-3 h-3 ms-1.5' xmlns='http://www.w3.org/2000/svg' fill='currentColor' viewBox='0 0 24 24'>
                <path d='M8.574 11.024h6.852a2.075 2.075 0 0 0 1.847-1.086 1.9 1.9 0 0 0-.11-1.986L13.736 2.9a2.122 2.122 0 0 0-3.472 0L6.837 7.952a1.9 1.9 0 0 0-.11 1.986 2.074 2.074 0 0 0 1.847 1.086Zm6.852 1.952H8.574a2.072 2.072 0 0 0-1.847 1.087 1.9 1.9 0 0 0 .11 1.985l3.426 5.05a2.123 2.123 0 0 0 3.472 0l3.427-5.05a1.9 1.9 0 0 0 .11-1.985 2.074 2.074 0 0 0-1.846-1.087Z'/>
            </svg></a>";
        echo "</div>";
        echo "</th>";
    }

    if (!empty($actions)) {
        echo "<th scope='col' class='px-6 py-3 text-[#F1EEEE]'>Aksi</th>";
    }
    echo "</tr>";
    echo "</thead>";

    // Table Body
    echo "<tbody class='text-base'>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr class='bg-[#FAFAFA] border-b border-gray-200'>";
        
        $isFirst = true;
        foreach ($row as $value) {
            if ($isFirst) {
                echo "<th scope='row' class='px-6 py-4 font-medium text-gray-900 whitespace-nowrap'>" . htmlspecialchars($value) . "</th>";
                $isFirst = false;
            } else {
                echo "<td class='px-6 py-4 text-stone-950'>" . htmlspecialchars($value) . "</td>";
            }
        }

        if (!empty($actions)) {
            echo "<td class='px-6 py-4'>";
            foreach ($actions as $label => $linkTemplate) {
                $href = $linkTemplate;
                foreach ($row as $key => $val) {
                    $href = str_replace("{" . $key . "}", urlencode($val), $href);
                }
        
                $isDelete = strpos(strtolower($label), 'hapus') !== false;
                $actionClass = $isDelete
                    ? 'text-red-600 hover:underline'
                    : 'text-yellow-600 hover:underline';
        
                $confirmAttr = $isDelete ? "onclick=\"return confirm('Apakah Anda yakin ingin menghapus data ini?');\"" : "";
                echo "<a href=\"$href\" class=\"font-medium $actionClass mr-2\" $confirmAttr>$label</a>";
            }
            echo "</td>";
        }
        

        echo "</tr>";
    }
    echo "</tbody>";

    echo "</table>";
    echo "</div>";
}
?>
