'use client'

import { getCookie } from 'cookies-next';
import { useRouter } from 'next/navigation';
import { useEffect, useState } from 'react'
import LoadingScreen from '../components/LoadingScreen';
import { collection, doc, getDocs, query, where } from 'firebase/firestore';
import { db } from '../services/firebaseConfig';
import { Manga } from '../types/manga';
import MangaGallery from './components/MangaGallery';
import { getAuth } from 'firebase/auth';
import useUserStore from '../store/userStore';

export default function Home() {

  const { user, verifyingAuth, checkAuth } = useUserStore()
  const [loading, setLoading] = useState(true)
  const [fetchingData, setFetchingData] = useState(true)
  const [mangasData, setmangasData] = useState<Manga[]>([])
  const auth = getAuth()
  const router = useRouter()

  const handleMangaFetch = async () => { 
    setLoading(true)
    try {
      const querySnapshot = await getDocs(collection(db, "manga"));
      const mangasList: Manga[] = await Promise.all(
        querySnapshot.docs.map(async (manga) => {
          const mangaDocRef = doc(db, "manga", manga.id);
          const volumesRef = collection(db, "volume");

          const q = query(volumesRef, where("mangaId", "==", mangaDocRef));
          const volumeSnapshot = await getDocs(q);
          const volumesData = volumeSnapshot.docs.map((doc: any) => ({
            id: doc.id,
            ...doc.data(),
          }));
          const purchasedVolumes = volumesData.filter(vol => vol.bought).length;

          return {
            id: manga.id,
            title: manga.data().title,
            purchasedVolumes,
            totalVolumes: volumesData.length,
            coverImageUrl: manga.data().coverImageUrl,
            bannerImgUrl: manga.data().bannerImgUrl,
          };
        })
      );
      console.log(mangasList);
      setmangasData(mangasList);
    } catch (error) {
      console.error("Error fetching mangas: ", error);
    }
    setLoading(false)
  };

  useEffect(() => {
    checkAuth(); 
  }, []);

  useEffect(() => {
    if (!verifyingAuth && !user) {
      router.push("/");
    }
  }, [user, verifyingAuth]);

  useEffect(() => {
    if (user) {
      handleMangaFetch();
    }
  }, [user]);

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
