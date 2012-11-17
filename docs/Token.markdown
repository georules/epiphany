Token
=======================
#### The Epiphany PHP Framework

----------------------------------------

### Understanding and using the token module

EpiToken provides an easy solution for prevention of cross-site request forgery (CSRF) and accidental form resubmission.  It depends on EpiSession to store a randomly generated token that can be placed on a POST form to syncronously verify a POST request. 

    Epi::init('token');

EpiToken adds a new unique token to the session for the user everytime addToken is called.

Using this resource is not RESTful, as it makes use of a server state (session token).  Maintaining  synchronous transaction tokens between transactions.

----------------------------------------

### Available methods

The available methods are `generateToken`, `validateToken`, `validateForm`, and `addToken`.  The simplest way to use this module is to place a token on a form you are currently constructing.

    getToken()->addToken();

Then, to validate a POST submission, simply provide the `$_POST` variable to `validateForm`.  This will return `true` if the token was found both in the request and in the session, and false if it was not found in one or both.
 
    $result = getToken()->validateForm($_POST);

The token will be invalidated when the form is validated.  This will prevent an accidental POST resubmission.  An example of this is in `examples/nonce-tokens`.  nonce is a term meaning the number (token) is to be used once.

----------------------------------------

### Special Notes

`addToken` will by default echo the hidden form inputs.  If you prefer, you can provide a `false` parameter so that the token is returned to you as an associative array.

    $t = getToken()->addToken(false);
    $token_key = $t['name'];
    $token_value = $t['token'];

You can manually generate a token and validate it providing a name (key) for that token.

    $name = "key";
    $token = getToken->generateToken($name);
    $tokenPost = $_POST['tokenValueName'];
    $isValid = getToken->validateToken($name,$tokenPost);
