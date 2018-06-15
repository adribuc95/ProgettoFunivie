

<%@page import="it.netsw.apps.igfs.cg.coms.api.init.IgfsCgInit" %>
<%@page import="it.netsw.apps.igfs.cg.coms.api.init.IgfsCgInit.*" %>
<%@page import="java.net.URL" %>
<%@page import="java.security.SecureRandom" %>
<%@page import="java.util.HashMap" %>
<%@page import="java.util.Map" %>
<%@page import="java.util.Properties" %>
<%@page import="java.io.InputStream" %>
<%
    
   email_utente = request.getParameter("email");
   importo_totale = request.getParameter("importo_totale");
// <?php

//if ($_SERVER["REQUEST_METHOD"] == "POST") {
         //   $importo_totale = htmlspecialchars($_POST["importo_totale"]);
         //   $email = htmlspecialchars($_POST["email"]);
            
//}
//$shopID = uniqid("shopID");
//?>
// = impostazione parametri per l?inizializzazione richiesta di       =
// = pagamento.                                                       =
// = NB: I parametri riportati sono solo a titolo di esempio          =
// ====================================================================
String serverURL = "https://testeps.netswgroup.it/UNI_CG_SERVICES/services";
int timeout = 15000;
String tid= "UNI_ECOM"; //per servizio MyBank usare UNI_MYBK
String kSig = "UNI_TESTKEY";
String shopID = "5687010820272485455"; // Chiave esterna UNIVOCA identificante il pagamento

String email = email_utente;
TrType trType = TrType.AUTH;
CurrencyCode curCode = CurrencyCode.EUR;
LangID langID = LangID.IT;
long amount = importo_totale."00";
String errorURL = "https://Esercente/error.jsp";
String notifyURL = "https://Esercente/notify.jsp";

IgfsCgInit init = new IgfsCgInit();
init.setServerURL(new URL(serverURL));
init.setTimeout(timeout);
init.setTid(tid);
init.setKSig(kSig);
init.setShopID(shopID);
init.setShopUserRef(email);
init.setTrType(trType);
init.setCurrencyCode(curCode);
init.setLangID(langID);
init.setAmount(amount);

init.setErrorURL(new URL(errorUrl));
init.setNotifyURL(new URL(notifyURL));
// ====================================================================
// =              esecuzione richiesta di inizializzazione            =
// ====================================================================
if (!init.execute()) {
     // ====================================================================
     // = redirect del client su pagina di errore definita dall?Esercente  =
     // ====================================================================
     response.sendRedirect(errorURL + "?rc=" + init.getRc() + "&errorDesc=" +
                            init.getErrorDesc());
return; }
String paymentID = init.getPaymentID();
// NOTA: Salvo il paymentID relativo alla richiesta (es. sul DB)...
// ====================================================================
// =              redirect del client verso URL PagOnline BuyNow           =
// ====================================================================
URL redirectURL = init.getRedirectURL();
response.sendRedirect(redirectURL.toString());
%>

