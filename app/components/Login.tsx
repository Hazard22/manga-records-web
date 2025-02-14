'use client';

import { Button } from "@mui/material";
import { getAuth, GoogleAuthProvider, signInWithPopup } from "firebase/auth";
import { useState } from "react";
import { FaGoogle } from "react-icons/fa";
import { firebase } from "../services/firebaseConfig";
import useUserStore from "../store/userStore";
import { useRouter } from "next/navigation";
import { setCookie } from "cookies-next";
import { ThreeDot } from "react-loading-indicators";

export default function Login() {
  const { setUser } = useUserStore();  // Usa `setUser` del store
  const auth = getAuth(firebase);
  const router = useRouter();

  const [loading, setLoading] = useState(false);

  const signInWithGoogle = async () => {
    setLoading(true);
    const provider = new GoogleAuthProvider();
    try {
      const result = await signInWithPopup(auth, provider);
      if (result.user) {
        setUser(result.user);  
        setCookie("userCookie", result.user.uid); 
        router.push("/mangas"); 
      }
    } catch (error: unknown) {
      if (error instanceof Error) {
        console.error("Error: ", error.message);
      } else {
        console.error("Error desconocido", error);
      }
    }
    setLoading(false);
  };

  return (
    <div className="bg-indigo-950 p-5 rounded-lg">
      <Button
        onClick={signInWithGoogle}
        variant="contained"
        startIcon={<FaGoogle />}
        disabled={loading}
      >
        {loading ? <ThreeDot size="small" color='#ffffff'/> : "Sign In with Google"}
      </Button>
    </div>
  );
}
