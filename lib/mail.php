<?php
function set_content_email($data)
{
    global $config;
    $total_price = 0;
    foreach($data as $value){
        $total_price += $value['price'] * $value['qty'];
    }
    $total_price = number_format($total_price, 0, ".", ".")."đ";
    $content = '';

    $content .= "<table class='shop-table'>";
    // Thead
    $content .=     "<thead>";
    $content .=         "<tr>";
    $content .= "           <td>Sản phẩm</td>";
    $content .= "           <td></td>";
    $content .= "           <td>Tổng</td>";
    $content .= "       </tr>";
    $content .= "   </thead>";
    // Tbody
    $content .=     "<tbody>";
    foreach ($data as $value) {
        $url_image = $config['base_url'] . 'admin/' . $value['url'];
        $sub_price = number_format(($value['price'] * $value['qty']), 0, ".", ".")."đ";
        $content .= "<tr class='cart-item'>";
        $content .= "<td><img width='75px' height='75px' src='{$url_image}' alt=''></td>";
        $content .= "<td style='text-align: left;' class='product-name'>{$value['name']}<strong class='product-quantity' style='color: #f12a43;'>x {$value['qty']}</strong></td>";
        $content .= "<td class='product-total' style='color: #f12a43;'>{$sub_price}</td>";
        $content .= "</tr>";
    }
    $content .= "</tbody>";

    // Tfoot
    $content .= "   <tfoot>";
    $content .= "       <tr class='order-total'>";
    $content .= "           <td>Tổng đơn hàng:</td>";
    $content .= "           <td></td>";
    $content .= "           <td><strong class='total-price' style='color: #f12a43;'>{$total_price}</strong></td>";
    $content .= "       </tr>";
    $content .= "   </tfoot>";
    $content .= "</table>";

    $content .= "<style>
    .shop-table {
        width: 100%;
        text-align: left;
    }

    .shop-table tr td:nth-child(2) {
        text-align: right;
    }

    .shop-table thead tr {
        border-bottom: 1px solid #ddd;
    }

    .shop-table thead tr td {
        text-transform: uppercase;
        padding-bottom: 15px;
        text-transform: uppercase;
        font-family: 'Roboto Medium';
    }

    .shop-table tbody tr td {
        padding: 15px 0px;
        border-bottom: 1px solid #ddd;
        display: table-cell;
        vertical-align: middle;
    }

    .shop-table tbody tr td .product-quantity {
        display: inline-block;
        padding-left: 10px;
        font-family: 'Roboto Medium';
        font-weight: normal;
        font-size: 13px;
    }

    .shop-table tfoot tr td {
        padding: 15px 0px;
        text-transform: uppercase;
        font-family: 'Roboto Medium';
        font-weight: normal;
    }
</style>";
    return $content;
}


