<?php

namespace Iamfredric\Fortnox\Resources;

use Iamfredric\Fortnox\Fortnox;

/**
 * @property-read double $AdministrationFee
 * @property-read double $AdministrationFeeVAT
 * @property-read string $Address1
 * @property-read string $Address2
 * @property-read double $Balance
 * @property-read double $BasisTaxReduction
 * @property-read bool $Booked
 * @property-read bool $Cancelled
 * @property-read string $City
 * @property-read string $Comments
 * @property-read int $ContractReference
 * @property-read double $ContributionPercent
 * @property-read double $ContributionValue
 * @property-read string $Country
 * @property-read string $CostCenter
 * @property-read string $Credit
 * @property-read string $CreditInvoiceReference
 * @property-read string $Currency
 * @property-read double $CurrencyRate
 * @property-read int $CurrencyUnit
 * @property-read string $CustomerName
 * @property-read string $CustomerNumber
 * @property-read string $DeliveryAddress1
 * @property-read string $DeliveryAddress2
 * @property-read string $DeliveryCity
 * @property-read string $DeliveryCountry
 * @property-read string $DeliveryDate
 * @property-read string $DeliveryName
 * @property-read string $DeliveryZipCode
 * @property-read string $DocumentNumber
 * @property-read string $DueDate
 * @property-read array $EDIInformation
 * @property-read array $EmailInformation
 * @property-read bool $EUQuarterlyReport
 * @property-read string $ExternalInvoiceReference1
 * @property-read string $ExternalInvoiceReference2
 * @property-read double $Freight
 * @property-read double $FreightVAT
 * @property-read double $Gross
 * @property-read bool $HouseWork
 * @property-read string $InvoiceDate
 * @property-read string $InvoicePeriodStart
 * @property-read string $InvoicePeriodEnd
 * @property-read string $InvoicePeriodReference
 * @property-read array $InvoiceRows
 * @property-read string $InvoiceType
 * @property-read array $Labels
 * @property-read string $Language
 * @property-read string $LastRemindDate
 * @property-read double $Net
 * @property-read bool $NotCompleted
 * @property-read bool $NoxFinans
 * @property-read string $OCR
 * @property-read string $OfferReference
 * @property-read string $OrderReference
 * @property-read string $OrganisationNumber
 * @property-read string $OurReference
 * @property-read string $PaymentWay
 * @property-read string $Phone1
 * @property-read string $Phone2
 * @property-read string $PriceList
 * @property-read string $PrintTemplate
 * @property-read string $Project
 * @property-read bool $WarehouseReady
 * @property-read string $OutboundDate
 * @property-read string $Remarks
 * @property-read int $Reminders
 * @property-read double $RoundOff
 * @property-read bool $Sent
 * @property-read int $TaxReduction
 * @property-read string $TermsOfDelivery
 * @property-read string $TermsOfPayment
 * @property-read int $TimeBasisReference
 * @property-read double $Total
 * @property-read double $TotalToPay
 * @property-read double $TotalVAT
 * @property-read bool $VATIncluded
 * @property-read int $VoucherNumber
 * @property-read string $VoucherSeries
 * @property-read int $VoucherYear
 * @property-read string $WayOfDelivery
 * @property-read string $YourOrderNumber
 * @property-read string $YourReference
 * @property-read string $ZipCode
 * @property-read string $AccountingMethod
 * @property-read string $TaxReductionType
 * @property-read string $FinalPayDate
 */
class Invoice extends Resource
{
    protected function getIdKey(): string
    {
        return 'DocumentNumber';
    }

    public static function send(int $id): static
    {
        $response = Fortnox::request('GET', self::getUrl("{$id}/email"));

        return new static($response[self::getResourceKey()]);
    }
}
