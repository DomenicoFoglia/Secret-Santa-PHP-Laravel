<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hai pescato il tuo regalo!</title>
</head>

<body style="font-family: Arial, sans-serif; background-color:#f7f7f7; padding:20px;">

    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center">
                <table width="600" cellpadding="20" cellspacing="0" style="background:white; border-radius:12px;">
                    <tr>
                        <td align="center">
                            <h2 style="color:#333;">🎁 GiftChaos - Il tuo Secret Santa</h2>
                            <p style="font-size:16px; color:#555;">
                                Ciao <strong>{{ $data['receiver_name'] }}</strong>! <br><br>
                                È arrivato il momento di scoprire chi dovrai sorprendere quest’anno!
                            </p>

                            <p style="font-size:18px; color:#000; margin-top:30px;">
                                🎅 Devi fare un regalo a:
                                <strong style="font-size:20px; color:#4f46e5;">
                                    {{ $data['assigned_to'] }}
                                </strong>
                            </p>

                            <p style="font-size:14px; color:#777; margin-top:30px;">
                                Buon divertimento e... sii creativo! ✨
                            </p>

                            <hr style="margin:30px 0; border:0; border-top:1px solid #eee;">

                            <p style="font-size:12px; color:#aaa;">
                                Questa email è stata generata automaticamente da <strong>GiftChaos</strong>.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

</body>

</html>
