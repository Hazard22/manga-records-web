import { initializeApp } from "firebase/app";
import { getFirestore } from "firebase/firestore"
import "firebase/auth"

const apiKey = process.env.NEXT_PUBLIC_FB_API_KEY
const projectId = process.env.NEXT_PUBLIC_FB_PROJECT_ID
const messagingSenderId = process.env.NEXT_PUBLIC_FB_MESSAGING_SENDER_ID
const appId = process.env.NEXT_PUBLIC_FB_APP_ID

const firebaseConfig = {
    apiKey,
    authDomain: `${projectId}.firebaseapp.com`,
    projectId,
    storageBucket: `${projectId}.firebasestorage.app`,
    messagingSenderId,
    appId,
}

const firebase = initializeApp(firebaseConfig)
const db = getFirestore(firebase)

export { firebase, db }