Lista transakcji dla konta ID: {{$account.id}}<br/>
<table border="1">
    <thead>
        <tr>
            <th>
                Data operacji
            </th>
            <th>
                Nadawca
            </th>
            <th>
                Odbiorca
            </th>
            <th>
                Tytuł przelewu
            </th>
            <th>
                Kwota
            </th>
            <th>
                Waluta
            </th>
            <th>
                Saldo po operacji
            </th>
        </tr>
    </thead>
    <tbody>
    {assign var=sum value=$openBalance}
    {foreach from=$transactions item=transaction}
        {if $account.id != $transaction.to_user}
            {assign var=sum value=$sum-$transaction.amount}
        {else}
            {assign var=sum value=$sum+$transaction.amount}
        {/if}
        <tr>
            <td>
                {$transaction.added}
            </td>
            <td>
                {$transaction.from_user}
            </td>
            <td>
                {$transaction.to_user}
            </td>
            <td>
                {$transaction.title}
            </td>
            <td style="text-align: right;">
                {if $account.id != $transaction.to_user}
                    -
                {/if}
                {$transaction.amount|number_format:2:".":","}
            </td>
            <td>
                {$transaction.currency}
            </td>
            <td style="text-align: right;">
                {$sum|number_format:2:".":","}
            </td>
        </tr>
    {/foreach}
    </tbody>
</table>
Saldo otwarcia: {{$openBalance|number_format:2:".":","}} PLN<br/>
Saldo końcowe: {{$sum|number_format:2:".":","}} PLN