<?php

namespace App\Helpers;

class MailContents
{
    public static function createProfileSubject(): string
    {
        return "New Profile Created";
    }

    public static function createProfileMessage($profileName, $institutionName, $packageName): string
    {
        return "<p>A new profile has been created. Kindly approve.</p>

        <ul>
            <li><strong>Name:</strong> {$profileName}</li>
            <li><strong>Institution:</strong> {$institutionName}</li>
             <li><strong>Role:</strong> {$packageName}</li>
        </ul>";
    }

    public static function updateProfileSubject(): string
    {
        return "Profile Update Request";
    }

    public static function updateProfileMessage(): string
    {
        return "<p>Profile has been updated. Kindly approve.</p>";
    }

    public static function deactivateProfileSubject(): string
    {
        return "Profile Deactivated";
    }

    public static function deactivateProfileMessage($profileName, $institutionName, $packageName, $reason): string
    {
        return "<p>A profile has been deactivated. Kindly approve</p>";
    }

    public static function approveProfileCreateSubject(): string
    {
        return "Profile Approved";
    }

    public static function approveProfileCreateMessage($email, $password): string
    {
        return "<p>Your account has been successfully created. These are your login credentials:</p>
           <ul>
            <li><strong>Registration ID:</strong> {$email}</li>
            <li><strong>Password:</strong> {$password}</li>
        </ul>
        ";
    }

    public static function approveProfileUpdateSubject(): string
    {
        return "Profile Updated";
    }

    public static function approveProfileUpdateMessage(): string
    {
        return "<p>Your request to update profile has been approved</p>";
    }

    public static function rejectProfileUpdateSubject(): string
    {
        return "Profile Update Rejected";
    }

    public static function rejectProfileUpdateMessage($reason): string
    {
        return "<p>This profile update has been rejected.</p>";
    }
    public static function rejectProfileCreateSubject(): string
    {
        return "Profile Rejected";
    }

    public static function rejectProfileCreateMessage($profileName, $institutionName, $packageName, $reason): string
    {
        return "<p>This profile has been rejected.</p>
           <ul>
            <li><strong>Name:</strong> {$profileName}</li>
            <li><strong>Institution:</strong> {$institutionName}</li>
            <li><strong>Role:</strong> {$packageName}</li>
            <li><strong>Reason:</strong> {$reason}</li>
        </ul>
        ";
    }
    public static function approveProfileDeleteSubject(): string
    {
        return "Profile Deactivation Approved";
    }

    public static function approveProfileDeleteMessage(): string
    {
        return "<p>The request to reject the profile has been approved</p>";
    }
    public static function rejectProfileDeleteSubject(): string
    {
        return "Profile Deactivation Rejected";
    }

    public static function rejectProfileDeleteMessage($reason): string
    {
        return "<p>The request to reject the profile has been deactivated.
        <ul><li>Reason: {$reason}</li></ul></p>";
    }


    public static function createCertificateSubject(): string
    {
        return "New Certificate Created";
    }

    public static function createCertificateMessage(): string
    {
        return "<p>A new certificate has been created. Kindly approve.</p>";
    }

    public static function approveCertificateCreateSubject(): string
    {
        return "Certificate Approved";
    }

    public static function approveCertificateCreateMessage(): string
    {
        return "<p>Certificate has been approved.</p>";
    }

    public static function rejectCertificateCreateSubject(): string
    {
        return "Certificate Rejected";
    }

    public static function rejectCertificateCreateMessage($reason): string
    {
        return "<p>Certificate has been approved.</p>
                <p>Reason:<strong>{$reason}</strong></p>";
    }

    public static function updateCertificateSubject(): string
    {
        return "Certificate Update";
    }

    public static function updateCertificateMessage(): string
    {
        return "<p>Certificate has been updated. Kindly approve.</p>";
    }

    public static function approveCertificateUpdateSubject(): string
    {
        return "Certificate Update Approved";
    }

    public static function approveCertificateUpdateMessage(): string
    {
        return "<p>Certificate update has been approved.</p>";
    }

    public static function rejectCertificateUpdateSubject(): string
    {
        return "Certificate Update Rejected";
    }

    public static function rejectCertificateUpdateMessage($reason): string
    {
        return "<p>Certificate has been rejected
        <ul>
        <il>Reason:<strong>{$reason}</strong></il>
        </ul>
        </p>";
    }

    public static function deleteCertificateSubject(): string
    {
        return "Certificate Delete";
    }

    public static function deleteCertificateMessage(): string
    {
        return "<p>Certificate has been deleted. Kindly approve.</p>";
    }

    public static function approveCertificateDeleteSubject(): string
    {
        return "Certificate Delete Approved";
    }

    public static function approveCertificateDeleteMessage(): string
    {
        return "<p>Certificate delete has been approved.</p>";
    }

    public static function rejectCertificateDeleteSubject(): string
    {
        return "Certificate Delete Rejected";
    }

    public static function rejectCertificateDeleteMessage($reason): string
    {
        return "<p>Certificate has been rejected
        <ul>
        <il>Reason:<strong>{$reason}</strong></il>
        </ul>
        </p>";
    }

    public static function createInstitutionSubject(): string
    {
        return "New Institution Created";
    }

    public static function createInstitutionMessage(): string
    {
        return "<p>A new certificate has been created. Kindly approve.</p>";
    }

    public static function approveInstitutionCreateSubject(): string
    {
        return "Institution Approved";
    }

    public static function approveInstitutionCreateMessage(): string
    {
        return "<p>Institution has been approved.</p>";
    }

    public static function rejectInstitutionCreateSubject(): string
    {
        return "Institution Rejected";
    }

    public static function rejectInstitutionCreateMessage($reason): string
    {
        return "<p>Institution has been approved.</p>
                <p>Reason:<strong>{$reason}</strong></p>";
    }

    public static function updateInstitutionSubject(): string
    {
        return "Institution Update";
    }

    public static function updateInstitutionMessage(): string
    {
        return "<p>Institution has been updated. Kindly approve.</p>";
    }

    public static function approveInstitutionUpdateSubject(): string
    {
        return "Institution Update Approved";
    }

    public static function approveInstitutionUpdateMessage(): string
    {
        return "<p>Institution update has been approved.</p>";
    }

    public static function rejectInstitutionUpdateSubject(): string
    {
        return "Institution Update Rejected";
    }

    public static function rejectInstitutionUpdateMessage($reason): string
    {
        return "<p>Institution update has been rejected.
        <ul>
        <il>Reason:<strong>{$reason}</strong></il>
        </ul>
        </p>";
    }

    public static function deleteInstitutionSubject(): string
    {
        return "Institution Delete";
    }

    public static function deleteInstitutionMessage(): string
    {
        return "<p>Institution has been deleted. Kindly approve.</p>";
    }

    public static function approveInstitutionDeleteSubject(): string
    {
        return "Institution Delete Approved";
    }

    public static function approveInstitutionDeleteMessage(): string
    {
        return "<p>Institution delete has been approved.</p>";
    }

    public static function rejectInstitutionDeleteSubject(): string
    {
        return "Institution Delete Rejected";
    }

    public static function rejectInstitutionDeleteMessage($reason): string
    {
        return "<p>Institution has been rejected
        <ul>
        <il>Reason:<strong>{$reason}</strong></il>
        </ul>
        </p>";
    }

    public static function createAuctionSubject(): string
    {
        return "New Auction Created";
    }

    public static function createAuctionMessage(): string
    {
        return "<p>A new auction has been created. Kindly approve.</p>";
    }

    public static function updateAuctionSubject(): string
    {
        return "Auction Update";
    }

    public static function updateAuctionMessage(): string
    {
        return "<p>Auction has been updated. Kindly approve.</p>";
    }

    public static function forgotPasswordSubject(): string
    {
        return "Forgot Password";
    }

    public static function forgotPasswordMessage($link): string
    {
        return "<p>Kindly use the link below to reset your password:</p>
        <a href='{$link}'>Reset Password</a>";
    }

    public static function resetPasswordSubject(): string
    {
        return "Reset Password";
    }

    public static function resetPasswordMessage(): string
    {
        return "<p>Your password reset was successful.</p>";
    }

    // auctioneer mail after receiving bid
    public static function placeAuctionBidSubject(): string
    {
        return "Bid for Auction";
    }

    public static function placeAuctionBidMessage($security): string
    {
        return "<p>A new auction bid has been placed for Security: {$security}</p>";
    }

    // bidder mail after placing bid
    public static function placeAuctionBidForBidderSubject(): string
    {
        return "Bid for Auction";
    }

    public static function placeAuctionBidForBidderMessage($security): string
    {
        return "<p>You have been placed an auction bid for Security: {$security}</p>";
    }

    // auctioneer mail after updating bid
    public static function updateAuctionBidSubject(): string
    {
        return "Update on Auction Bid";
    }

    public static function updateAuctionBidMessage($security): string
    {
        return "<p>Update for auction bid has been placed for Security: {$security}</p>";
    }

    // bidder mail after updating bid
    public static function updateAuctionBidForBidderSubject(): string
    {
        return "Update Auction Bid";
    }

    public static function updateAuctionBidForBidderMessage($security): string
    {
        return "<p>You have updated the auction bid placed for Security: {$security}</p>";
    }
}
