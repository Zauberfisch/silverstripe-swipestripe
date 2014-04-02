<% with Cart %>
<table id="checkout-order-table" class="table table-bordered">
	<thead>
		<tr>
			<th class="product-column"><% _t('CheckoutFormOrder.PRODUCT', 'Product') %></th>
			<th class="price-column"><%t CheckoutFormOrder.PRICE 'Price ({currency})' currency=$TotalPrice.Currency %></th>
			<th class="quantity-column"><% _t('CheckoutFormOrder.QUANTITY', 'Quantity') %></th>
			<th class="totals-column"><%t CheckoutFormOrder.TOTAL_COLUMN 'Total ({currency})' currency=$TotalPrice.Currency %></th>
		</tr>
	</thead>
	<tbody>
		<% if Items %>
			<% loop Top.ItemsFields %>
				$FieldHolder
			<% end_loop %>
		<% else %>
			<tr>
				<td colspan="4">
					<div class="error"><% _t('CheckoutFormOrder.NO_ITEMS_IN_CART','There are no items in your cart.') %></div>
				</td>
			</tr>
		<% end_if %>

		<% loop Top.SubTotalModificationsFields %>
			$FieldHolder
		<% end_loop %>

		<% if $Top.TotalModificationsFields %>
			<tr>
				<td class="row-header"><% _t('CheckoutFormOrder.SUB_TOTAL','Sub Total') %></td>
				<td class="totals-column" colspan="3">$SubTotalPrice.Nice</td>
			</tr>
		<% end_if %>

		<% loop Top.TotalModificationsFields %>
			$FieldHolder
		<% end_loop %>
		<tr class="total-price">
			<td class="row-header"><% _t('CheckoutFormOrder.TOTAL','Total') %></td>
			<td class="totals-column" colspan="3">$TotalPrice.Nice</td>
		</tr>
		<% if $AfterTotal %>
			$AfterTotal
		<% end_if %>
	</tbody>
</table>
<% end_with %>