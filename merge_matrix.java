 import java.util.*;
public class merge_matrix
{
	public static void main(String args[])
	{
		int arr[]=new int[20];
		arr[0]=0;
		arr[1]=1;
		for(int i=2; i<20; i++)
		{
			arr[i]=arr[i-1]-arr[i-2];
		}
		for(int i=0; i<20; i++)
		{
			System.out.print(arr[i]+", ");
		}
/*		for(int i=2; i<20; i++)
		{
			arr[j]=arr[j-1]-arr[j-2];
		}
		for(int j=0; j<20; j++)
		{
			System.out.print(arr[j]+", ");
		}*/
	}
}
