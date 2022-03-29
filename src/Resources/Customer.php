<?php

namespace Iamfredric\Fortnox\Resources;

/**
 * @property-read string $Address1
 * @property-read string $Address2
 * @property-read string $City
 * @property-read string $Country
 * @property-read string $Comments
 * @property-read string $Currency
 * @property-read string $CostCenter
 * @property-read string $CountryCode
 * @property-read bool $Active
 * @property-read string $CustomerNumber
 * @property-read array $DefaultDeliveryTypes
 * @property-read array $DefaultTemplates
 * @property-read string $DeliveryAddress1
 * @property-read string $DeliveryAddress2
 * @property-read string $DeliveryCity
 * @property-read string $DeliveryCountry
 * @property-read string $DeliveryCountryCode
 * @property-read string $DeliveryFax
 * @property-read string $DeliveryName
 * @property-read string $DeliveryPhone1
 * @property-read string $DeliveryPhone2
 * @property-read string $DeliveryZipCode
 * @property-read string $Email
 * @property-read string $EmailInvoice
 * @property-read string $EmailInvoiceBCC
 * @property-read string $EmailInvoiceCC
 * @property-read string $EmailOffer
 * @property-read string $EmailOfferBCC
 * @property-read string $EmailOfferCC
 * @property-read string $EmailOrder
 * @property-read string $EmailOrderBCC
 * @property-read string $EmailOrderCC
 * @property-read string $ExternalReference
 * @property-read string $Fax
 * @property-read string $GLN
 * @property-read string $GLNDelivery
 * @property-read string $InvoiceAdministrationFee
 * @property-read double $InvoiceDiscount
 * @property-read string $InvoiceFreight
 * @property-read string $InvoiceRemark
 * @property-read string $Name
 * @property-read string $OrganisationNumber
 * @property-read string $OurReference
 * @property-read string $Phone1
 * @property-read string $Phone2
 * @property-read string $PriceList
 * @property-read string $Project
 * @property-read string $SalesAccount
 * @property-read bool $ShowPriceVATIncluded
 * @property-read string $TermsOfDelivery
 * @property-read string $TermsOfPayment
 * @property-read string $Type
 * @property-read string $VATNumber
 * @property-read string $VATType
 * @property-read string $VisitingAddress
 * @property-read string $VisitingCity
 * @property-read string $VisitingCountry
 * @property-read string $VisitingCountryCode
 * @property-read string $VisitingZipCode
 * @property-read string $WayOfDelivery
 * @property-read string $WWW
 * @property-read string $YourReference
 * @property-read string $ZipCode
 */
class Customer extends Resource
{
    protected function getIdKey(): string
    {
        return 'CustomerNumber';
    }
}
