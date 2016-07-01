<style>
table {
    border-collapse: collapse;
}

td {
    padding: 1em;
    border-bottom: 1px #F2F2F2 solid;
}

tr {
    background-color: rgb(250, 250, 250);;
}
tr:nth-child(odd) { 
	background-color: rgb(240, 240, 240);; 
}

</style>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h3>Frequently Asked Questions</h3>  
		</div>
	</div>
	<hr class="hr-small">
	
	<div class="row sm-margin-vert">
		<div class="col-md-12">

			<table border="0" cellpadding="5" cellspacing="5" width="100%">
        <tr>
            <td>
                <p align="justify"><strong>Q: How secure is MuslimHarmony?</strong></p>
                <p align="justify">A: Muslim Harmony is completely safe and
                secure. We protect all your contact information until you
                decide to release it yourself. All our payments are processed
                through PayPal which is one of the most secure online payment
                systems in the world.</p>
            </td>
        </tr>
        <tr>
            <td>
                <p align="justify"><strong>Q: How do I best view the site?</strong></p>
                <p align="justify">A: MuslimHarmony is best viewed using the
                chrome or firefox browser.</p>
            </td>
        </tr>
        <tr>
            <td>
                <p align="justify"><strong>Q: What happens to my Membership after it expires?</strong></p>
                <p align="justify">A: Once your membership expires your
                membership status automatically converts to "expired" status
                and you lose all actionable benefits of your membership. You
                can simply renew your membership by clicking on "My Membership"
                and you can select any package you like.</p>
            </td>
        </tr>
        <tr>
            <td>
                <p align="justify"><strong>Q: How do I pay for a membership?</strong></p>
                <p align="justify">A: We currently accept payments via PayPal
                through our site. PayPal accepts all major credit cards and if
                you have a PayPal account you can make your payments through
                your account as well.</p>
            </td>
        </tr>
        <tr>
            <td>
                <p align="justify"><strong>Q: How do you monitor the Site?</strong></p>
                <p align="justify">A: Any updates done by any member of the
                site is monitored and viewed by our staff. All communication is
                flagged as well if any inappropriate language is used.</p>
            </td>
        </tr>
        <tr>
            <td>
                <p align="justify"><strong>Q: What can I do if another member behaves
                inappropriately?</strong></p>
                <p align="justify">A: If you encounter anything inappropriate
                from any other member on our site please click on "Report
                Abuse" and notify us immediately. Provide us the time, date and
                the concern you have so we can address the matter swiftly.</p>
            </td>
        </tr>
        <tr>
            <td>
                <p align="justify"><strong>Q: How does the Message Centre Work?</strong></p>
                <p align="justify">A: It's a very user friendly interface that
                anyone can use who has ever used email. You can only
                communicate with people that are part of your matches. If you
                are a paid member you can communicate with all members, whether
                paid or unpaid.</p>
            </td>
        </tr>
        <tr>
            <td>
                <p align="justify"><strong>Q: If I am very specific in my locality will it affect the number of
                matches I receive?</strong></p>
                <p align="justify">A: The more specific you are about what you
                are looking for in terms of ethnicity, age, height, locality
                etc. will highly determine the amount of matches you will
                receive. You should be very careful in selecting the most
                important things in this portion of the profile.</p>
            </td>
        </tr>
        <tr>
            <td>
                <p align="justify"><strong>Q: Can anyone use the Advice Central portion of the site?</strong></p>
                <p align="justify">A: Advice Central is created for the use of
                not only members but anyone who would like to benefit from it.
                The site is a good resource for all people whether they are
                married, have a family or are looking to get married. We have a
                strong team working for the sake of Allah to benefit people in
                creating strong families within the Muslim Community.</p>
            </td>
        </tr>
        <tr>
            <td>
                <p align="justify"><strong>Q: I am having some technical difficulties on the site; what should I
                do?</strong></p>
                <p align="justify">A: Please send us an email at <a href="mailto:admin@muslimharmony.com">admin@muslimharmony.com</a> 
                with your concern and we will respond back to you as soon as possible.</p>
            </td>
        </tr>
        <tr>
            <td>
                <p align="justify"><strong>Q: How is the Wali/Guardian involved in the process?</strong></p>
                <p align="justify">A: If Wali/Guardian information is provided
                to us in the sign up process they are copied on all major
                activities by the profile they are linked to.</p>
            </td>
        </tr>
        <tr>
            <td>
                <p align="justify"><strong>Q: Can I make changes to my profile after originally creating it?</strong></p>
                <p align="justify">A: Any updates can be done if you sign in
                and click on "My Profile" to make any necessary changes.</p>
            </td>
        </tr>
    </table>

		</div>
	</div>
</div>

<script type="text/javascript">

$(document).ready(function() {

	<?php
	if (! Yii::app ()->user->isGuest) {
		?> 
	longPoll(); 
	<?php
	}
	?>
    
});
</script>


