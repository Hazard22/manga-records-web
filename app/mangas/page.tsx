'use client'

import { getCookie } from 'cookies-next';
import { useRouter } from 'next/navigation';
import { useEffect, useState } from 'react'
import LoadingScreen from '../components/LoadingScreen';
import { collection, getDocs } from 'firebase/firestore';
import { db } from '../services/firebaseConfig';
import { Button } from '@mui/material';
import { Manga } from '../types/manga';
import MangaGallery from './components/MangaGallery';

export default function Home() {

  const [loading, setLoading] = useState(true)
  const [fetchingData, setFetchingData] = useState(true)
  const [mangasData, setmangasData] = useState<Manga[]>([])
  const router = useRouter()

  const handleMangaFetch = async () => { 
    try {
        const querySnapshot = await getDocs(collection(db, "manga"));
        const mangasData: Manga[] = querySnapshot.docs.map((doc) => ({
            id: doc.id,
            ...(doc.data() as Omit<Manga, "id">), 
        }));
        console.log(mangasData);
        setmangasData(mangasData)
    } catch (error) {
        console.error("Error obteniendo mangas: ", error);
    }
  };

  useEffect(() => {

    const verifyAuth = () => { 
      const userToken = getCookie('userCookie'); 
      if (!userToken) {
          router.push('/'); 
      } 

      setLoading(false)
    }

    verifyAuth()
    handleMangaFetch()
    
  }, []);

  return (
    <div className='p-4'>
    {loading 
    ? <LoadingScreen/>
    : 
      <>
      {mangasData.length > 0 
      ? <MangaGallery mangas={mangasData}/>
      : <h2>No se encontraron mangas</h2>
      }
      </>
    }
    </div>
  )
}
