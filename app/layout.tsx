import "./ui/globals.css";
import { AppRouterCacheProvider } from "@mui/material-nextjs/v15-appRouter"
import { Roboto } from 'next/font/google';
import { ThemeProvider } from '@mui/material/styles';
import theme from './ui/theme';
import { CssBaseline } from "@mui/material";

const roboto = Roboto({
  weight: ['300', '400', '500', '700'],
  subsets: ['latin'],
  display: 'swap',
  variable: '--font-roboto',
});

export default function RootLayout({
  children,
}: Readonly<{
  children: React.ReactNode;
}>) {
  return (
    <html lang="es">
        <body
          className={`${roboto.className} antialiased`}
        >
          <AppRouterCacheProvider>
            <ThemeProvider theme={theme}>
              <CssBaseline/>
              {children}
            </ThemeProvider>
          </AppRouterCacheProvider>
        </body>
    </html>
  );
}
