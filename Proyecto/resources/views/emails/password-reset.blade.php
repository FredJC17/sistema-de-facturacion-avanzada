<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperación de Contraseña - SFA</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f3f4f6;
            padding: 20px;
        }
        
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        }
        
        .header {
            background: linear-gradient(135deg, #166866 0%, #1e8582 100%);
            padding: 40px 30px;
            text-align: center;
        }
        
        .logo {
            width: 80px;
            height: 80px;
            margin: 0 auto 15px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .header h1 {
            color: white;
            font-size: 24px;
            margin: 0;
        }
        
        .content {
            padding: 40px 30px;
        }
        
        .greeting {
            font-size: 18px;
            color: #1f2937;
            margin-bottom: 20px;
        }
        
        .message {
            font-size: 15px;
            color: #6b7280;
            line-height: 1.8;
            margin-bottom: 30px;
        }
        
        .code-box {
            background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
            border: 2px solid #3b82f6;
            border-radius: 12px;
            padding: 30px;
            text-align: center;
            margin: 30px 0;
        }
        
        .code-label {
            font-size: 14px;
            color: #1e40af;
            font-weight: 600;
            margin-bottom: 10px;
        }
        
        .code {
            font-size: 48px;
            font-weight: 700;
            color: #166866;
            letter-spacing: 8px;
            font-family: 'Courier New', monospace;
        }
        
        .expiry {
            margin-top: 15px;
            font-size: 13px;
            color: #ef4444;
            font-weight: 500;
        }
        
        .warning {
            background: #fef2f2;
            border-left: 4px solid #ef4444;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
        }
        
        .warning-text {
            font-size: 13px;
            color: #991b1b;
            line-height: 1.6;
        }
        
        .footer {
            background: #f9fafb;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #e5e7eb;
        }
        
        .footer-text {
            font-size: 13px;
            color: #6b7280;
            margin-bottom: 5px;
        }
        
        .social-icons {
            margin-top: 20px;
        }
        
        .icon {
            width: 32px;
            height: 32px;
            background: #166866;
            color: white;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin: 0 5px;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <div class="logo">
                <svg width="50" height="50" viewBox="0 0 100 100">
                    <text x="50" y="70" font-size="60" font-weight="bold" fill="#166866" text-anchor="middle">S</text>
                </svg>
            </div>
            <h1>Sistema de Facturación Avanzada</h1>
        </div>
        
        <!-- Content -->
        <div class="content">
            <p class="greeting">Hola {{ $user->nombre }},</p>
            
            <p class="message">
                Hemos recibido una solicitud para restablecer tu contraseña. Para continuar con el proceso, 
                utiliza el siguiente código de verificación:
            </p>
            
            <div class="code-box">
                <p class="code-label">TU CÓDIGO DE VERIFICACIÓN</p>
                <div class="code">{{ $code }}</div>
                <p class="expiry">⏱ Este código expira en 15 minutos</p>
            </div>
            
            <p class="message">
                Ingresa este código en la página de recuperación de contraseña para completar el proceso.
            </p>
            
            <div class="warning">
                <p class="warning-text">
                    <strong>⚠️ Importante:</strong> Si no solicitaste este cambio de contraseña, 
                    ignora este correo y tu cuenta permanecerá segura. Nadie podrá acceder sin este código.
                </p>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="footer">
            <p class="footer-text">© {{ date('Y') }} SFA - Sistema de Facturación Avanzada</p>
            <p class="footer-text" style="color: #9ca3af;">
                Este es un correo automático, por favor no respondas a este mensaje.
            </p>
        </div>
    </div>
</body>
</html>
