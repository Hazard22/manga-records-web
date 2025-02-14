'use client'

import { Button } from "@mui/material";
import { getAuth, GoogleAuthProvider, signInWithPopup } from "firebase/auth";
import { useEffect, useState } from "react";
import { FaGoogle } from "react-icons/fa";
import { firebase } from "../services/firebaseConfig";
import useUserStore from "../store/userStore";
import { useRouter } from "next/navigation";
import { setCookie } from "cookies-next";

export default function Login() {

    const { updateUser } = useUserStore()
    const auth = getAuth(firebase)
    const router = useRouter()

    const [login, setLogin] = useState(false)

    const signInWithGoogle = async () => { 
        setLogin(true)
        const provider = new GoogleAuthProvider()
        try {
          await signInWithPopup(auth, provider);
        } catch (error: unknown) {
          if (error instanceof Error) {
            console.error("Error: ", error.message);
          } else {
            console.error("Error desconocido", error);
          }
        } 
        setLogin(false)   
    }

    useEffect(() => {

      const handleSubscribe = async () => { 
        const unsubscribe = auth.onAuthStateChanged((user) => {
          if(user){
            updateUser(user)
            setCookie('userCookie', user.uid)
            router.push('/mangas')
          }else{
            updateUser(null)
            router.push('/')
          }
        })
    
        return () => unsubscribe()
      }

      handleSubscribe()
        
    }, [auth,])

    return (
      <div className="bg-indigo-950 p-5 rounded-lg ">
        <Button 
        onClick={signInWithGoogle}
        variant="contained"
        startIcon={<FaGoogle/>}
        loading={login}
        >
            Sign In with Google
        </Button>
    </div>
    )
}
