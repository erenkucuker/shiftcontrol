import 'tailwindcss/tailwind.css'
import Head from "next/head";
import { Nav, RouteGuard } from "components";

function MyApp({ Component, pageProps }) {
  
  return (
    <>
      <Head>
        <title>Shift Controller App</title>
      </Head>
      <div className="app-container bg-light">
        <Nav/>
        <div className="container pt-4 pb-4">
          <RouteGuard>
            <Component {...pageProps} />
          </RouteGuard>
        </div>
      </div>
    </>
  );
}

export default MyApp
